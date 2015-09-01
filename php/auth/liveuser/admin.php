<?php
/**
 * Administration page
 */
require_once 'conf.php';
require_once 'createlu.php';
require_once 'liveuser_rights.php';
require_once 'HTML/Template/IT.php';

if (!$usr->isLoggedIn() || !$usr->checkRight(EDITNEWS)) {
    echo 'Sorry but you cannot access this page';
    exit;
}

if (array_key_exists('news', $_POST)) {
    if (!$usr->checkRight(MODIFYNEWS)) {
        echo 'You are trying to modify a news but do not have the right to do so !';
        exit;
    }
    if (array_key_exists('id', $_POST)) {
        $id = (int)$_POST['id'];
        $title = htmlspecialchars(strip_tags($_POST['title']));
        $newscontent = htmlspecialchars(strip_tags($_POST['newscontent']));
        if ($id == 0) {
            insertNews($auth_db, $title, $newscontent, $usr->getProperty('perm_user_id'));
        } else {
            updateNewsContent($auth_db, $id, $title, $newscontent, $usr->getProperty('perm_user_id'));
        }
    }
}

$category = 'general';

if (array_key_exists('mode', $_GET) && $_GET['mode'] == 'edit') {
    if (!array_key_exists('id', $_GET) && !is_numeric($_GET['id'])) {
        die('Missing news id');
    }

    $id = (int)$_GET['id'];
    $news = getNewsContent($auth_db, $id);
} elseif (array_key_exists('mode', $_GET) && $_GET['mode'] == 'insert') {
    $news = getNewsContent($auth_db);
} else {
    $news = getNewsList($auth_db, $category);
}

$tpl =& new HTML_Template_IT('./');
$tpl->loadTemplatefile('admin.tpl');

// assign the content to the vars
$tpl->setVariable('USER', $usr->getProperty('handle'));
$tpl->setVariable('NEWS', $news);

$tpl->show();

/**
 * Returns news list
 * for a given category
 *
 * @param  object  &$auth_db      a reference to a db connection object
 * @param  string  $category news category
 */
function getNewsList(&$auth_db, $category)
{
    $query = "
        SELECT
            news_id      AS assockey,
            news_id      AS id,
            DATE_FORMAT(news_date, '%D %b %Y at %H:%I:%S') AS date,
            news_title   AS title
        FROM
            news
        WHERE
            news_category = ". $auth_db->quote($category, 'text');

    $news = $auth_db->queryAll($query, null, MDB2_FETCHMODE_ASSOC, true);

    if (PEAR::isError($news)) {
        die($news->getMessage() . ' ' . $news->getUserinfo());
    } else {
        $tpl =& new HTML_Template_IT('./');

        $tpl->loadTemplatefile('news_list.tpl', false, false);

        $tpl->setVariable('CATEGORY', ucfirst($category));

        foreach ($news as $id => $name) {
            foreach ($name as $cell) {
                // Assign data to the inner block
                $tpl->setCurrentBlock('cell');
                $tpl->setVariable("ID",   $id);
                $tpl->setVariable("DATA", nl2br($cell));
                $tpl->parseCurrentBlock('cell');
            }
            // Assign data and the inner block to the
            // outer block
            $tpl->setCurrentBlock('row');
            $tpl->parseCurrentBlock('row');
        }
        return $tpl->get();
    }

}

/**
 * Get a news content.
 *
 * @param  object  &$auth_db     a reference to a db connection object
 * @param int     $id      news id
 * @param  string  $content the new content
 * @return string content as a string
 */
function getNewsContent(&$auth_db, $news = null)
{
    if (!is_null($news)) {
        $query = "
            SELECT
                news_id      AS id,
                news_title   AS title,
                DATE_FORMAT(news_date, '%D %b %Y at %H:%I:%S') AS date,
                news_content AS content
            FROM
                news
            WHERE
                news_id = $news";

        $news = $auth_db->queryRow( $query );
    }

    if  (PEAR::isError($news)) {
        die($news->getMessage() . ' ' . $news->getUserinfo());
    } else {
        $tpl =& new HTML_Template_IT('./');

        $tpl->loadTemplatefile('news_edit.tpl', false, false);

        $tpl->setVariable('ID',      $news['id']);
        $tpl->setVariable('TITLE',   $news['title']);
        $tpl->setVariable('DATE',    $news['date']);
        $tpl->setVariable('CONTENT', $news['content']);

        return $tpl->get();
    }

}

/**
 * Update a news content
 *
 * @param  object  &$auth_db     a reference to a db connection object
 * @param int     $id      news id
 * @param  string  $content the new content
 * @return void
 */
function updateNewsContent(&$auth_db, &$id, $title, $content, $user)
{
    $content = strip_tags($content);
    $query = '
        UPDATE
            news
        SET
            news_content = ' . $auth_db->quote($content, 'text') . ',
            news_title = ' . $auth_db->quote($title, 'text') . '
        WHERE
            news_id = "' . $id . '"';

    $auth_db->query($query);
}

/**
 * Insert news in database
 *
 * @param  object  &$auth_db     a reference to a db connection object
 * @param  string  $title   news title
 * @param  string  $content the new content
 * @return void
 */
function insertNews(&$auth_db, $title, $content, $user)
{
    $content = strip_tags($content);
    $query = '
        INSERT INTO
            news
        (news_id, news_date,
        news_title, news_content)
        VALUES
        ("' . $auth_db->nextId('news') . '", "' . date('Y-m-d H:i:s') . '",
        ' . $auth_db->quote($title, 'text') . ', ' . $auth_db->quote($content, 'text') . ')';

    $auth_db->query($query);
}
?>
