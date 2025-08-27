CREATE TABLE applications.ijin (
  id BIGSERIAL,
  nopeg VARCHAR(20) NOT NULL,
  tgl_awal DATE NOT NULL,
  tgl_akhir DATE NOT NULL,
  keterangan VARCHAR(255) NOT NULL,
  jumlah INTEGER NOT NULL,
  approval BOOLEAN,
  nopeg_atasan VARCHAR(20) NOT NULL,
  lampiran text,
  created_at TIMESTAMP(0) WITHOUT TIME ZONE,
  updated_at TIMESTAMP(0) WITHOUT TIME ZONE,
  PRIMARY KEY(id),
  FOREIGN KEY (nopeg)
    REFERENCES applications.pegawai(nopeg)
    ON DELETE CASCADE
    ON UPDATE CASCADE
    NOT DEFERRABLE,
  FOREIGN KEY (nopeg_atasan)
    REFERENCES applications.pegawai(nopeg)
    ON DELETE CASCADE
    ON UPDATE CASCADE
    NOT DEFERRABLE
) ;

ALTER TABLE applications.cuti ADD COLUMN lampiran TEXT;
