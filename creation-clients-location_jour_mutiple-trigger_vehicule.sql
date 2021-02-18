CREATE TABLE IF NOT EXISTS ec_clients (
    id_client INT AUTO_INCREMENT,
    PRIMARY KEY (id_client),
    c_nom VARCHAR(50),
    c_prenom VARCHAR(50),
    c_email VARCHAR(80),
    c_telephone INT(10) ZEROFILL UNSIGNED,
    c_statut ENUM("Premium","Basic"),
    c_vehicule_prefere INT DEFAULT NULL,
    FOREIGN KEY (c_vehicule_prefere) REFERENCES ec_modele(m_id) ON DELETE SET NULL,
    c_date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE IF NOT EXISTS ec_location (
    loc_id INT AUTO_INCREMENT,
    PRIMARY KEY (loc_id),
    loc_debut DATE,
    loc_fin DATE,
    loc_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    loc_fk_vehicule INT,
    FOREIGN KEY (loc_fk_vehicule) REFERENCES ec_flotte(f_id) ON DELETE RESTRICT,
    loc_fk_client INT,
    FOREIGN KEY (loc_fk_client) REFERENCES ec_clients(c_id) ON DELETE RESTRICT
    )

DELIMITER $$
CREATE TRIGGER `add_vehicule` AFTER INSERT ON `ec_agence`
FOR EACH ROW BEGIN
INSERT INTO ec_flotte
SELECT NULL , NEW.a_id , m_id FROM ec_modele;
END $$
