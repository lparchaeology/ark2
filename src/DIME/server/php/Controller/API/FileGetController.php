<?php

/**
 * DIME Controller.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
 *
 * This file is part of ARK, the Archaeological Recording Kit.
 *
 * ARK is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ARK is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ARK.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     John Layt <j.layt@lparchaeology.com>
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace DIME\Controller\API;

use ARK\File\File;
use ARK\Model\Fragment\ItemFragment;
use ARK\ORM\ORM;
use ARK\Service;
use League\Glide\Responses\SymfonyResponseFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class FileGetController
{
    public function __invoke(Request $request, $id) : Response
    {
        // TODO Wrap in a nice neat class or Service call
        $file = File::find($id);
        if (!$file) {
            throw new NotFoundHttpException("File $id not found");
        }
        // DIME File Security
        // In DIME files do not exisit in their own right, they are an arefact of their owner, i.e. a Find.
        // As such we need to first check the security of the file itself, then check the security where it is used.
        $actor = Service::workflow()->actor();
        if ($file->visibility()->name() !== 'public' && !Service::workflow()->can($actor, 'view', $file)) {
            throw new AccessDeniedException('core.error.access.denied');
        }
        $frags = ORM::findBy(ItemFragment::class, ['parameter' => 'file', 'value' => $file->id()]);
        foreach ($frags as $frag) {
            $item = $frag->owner();
            if ($item->visibility()->name() !== 'public' && !Service::workflow()->can($actor, 'view', $item)) {
                throw new AccessDeniedException('core.error.access.denied');
            }
        }
        $factory = new SymfonyResponseFactory($request);
        $response = $factory->create(Service::filesystem(), $file->path());
        $disposition = ($request->query->has('d') ? ResponseHeaderBag::DISPOSITION_INLINE : ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        $response->headers->set('Content-Disposition', $response->headers->makeDisposition($disposition, $file->name()));
        return $response;
    }
}
