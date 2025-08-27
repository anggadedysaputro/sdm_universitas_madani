delete from applications.cuti;
ALTER TABLE applications.cuti ADD COLUMN nopeg_atasan VARCHAR(20) NOT NULL;
ALTER TABLE applications.cuti
  ADD CONSTRAINT cuti_fk1 FOREIGN KEY (nopeg_atasan)
    REFERENCES applications.pegawai(nopeg)
    ON DELETE CASCADE
    ON UPDATE CASCADE
    NOT DEFERRABLE;
