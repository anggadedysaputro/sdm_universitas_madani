ALTER TABLE applications.pegawai ADD COLUMN token_id TEXT;
COMMENT ON COLUMN applications.pegawai.token_id IS 'untuk fcm token firebase';
