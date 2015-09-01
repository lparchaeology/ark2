alter table cor_tbl_cmap_structure add column (raw_stecd_tbl varchar(255) NOT NULL, raw_stecd_col varchar(255) NOT NULL, raw_stecd_join_col varchar(255), NOT NULL, tbl_stecd_join_col varchar(255) NOT NULL);
alter table cor_tbl_cmap_data add column (mapto_class varchar(255) NOT NULL, mapto_classtype varchar(255) NOT NULL);
