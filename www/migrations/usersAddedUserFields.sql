ALTER TABLE `users`
    ADD COLUMN `birthday` date,
    ADD COLUMN `gender` enum('male','female') NOT NULL DEFAULT 'male',
    ADD COLUMN `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
    ADD COLUMN `moderated_by` int(11) UNSIGNED NULL,
    ADD COLUMN `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ADD CONSTRAINT `fk_users_moderated_by_users_id`
        FOREIGN KEY (moderated_by) REFERENCES users(id);

CREATE table `contact_types` (
    id int(2) UNSIGNED NOT NULL AUTO_INCREMENT primary key,
    name varchar(255) NOT NULL
);

CREATE table `contacts` (
    type_id int(11) NOT NULL,
    contact varchar(255) NOT NULL,
    user_id int(11) NOT NULL,
    CONSTRAINT `fk_contacts_type_id_contact_types_id`
        FOREIGN KEY (type_id) REFERENCES contact_types(id),
    CONSTRAINT `fk_contacts_user_id_users_id`
        FOREIGN KEY (user_id) REFERENCES users(id)
);