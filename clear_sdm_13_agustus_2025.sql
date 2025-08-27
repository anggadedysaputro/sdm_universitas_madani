ALTER TABLE applications.cuti ADD COLUMN approval_sdm BOOLEAN;
ALTER TABLE applications.konfigumum ADD COLUMN tglawalbulan INTEGER DEFAULT 0 NOT NULL;
ALTER TABLE applications.konfigumum ADD COLUMN tglakhirbulan INTEGER DEFAULT 0 NOT NULL;
CREATE OR REPLACE FUNCTION public.list_libur (
  intglawal date,
  intglakhir date
)
RETURNS TABLE (
  rettanggal date,
  retketerangan varchar,
  retwarna text
) AS
$body$
select tanggal, keterangan, 'white'
from masters.libur as l
where tanggal between intglawal and intglakhir
union
SELECT tanggal::date, concat('Libur hari ',k.harilibur), 'red'
FROM generate_series(
    intglawal::date,
    intglakhir::date,
    '1 day'::interval
) AS c(tanggal), applications.konfigumum as k
where array_position(ARRAY['MINGGU','SENIN','SELASA','RABU','KAMIS','JUM''AT','SABTU'],upper(k.harilibur)) = extract(dow from c.tanggal)+1;
$body$
LANGUAGE 'sql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
PARALLEL UNSAFE
COST 100 ROWS 1000;

ALTER FUNCTION public.list_libur (intglawal date, intglakhir date)
  OWNER TO postgres;
