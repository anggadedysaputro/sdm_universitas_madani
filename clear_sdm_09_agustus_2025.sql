ALTER TABLE applications.cuti ADD COLUMN approval BOOLEAN;
ALTER TABLE applications.konfigumum DROP CONSTRAINT konfigumum_pkey cascade;
DROP SEQUENCE applications.konfigumum_idkonfigumum_seq cascade;
