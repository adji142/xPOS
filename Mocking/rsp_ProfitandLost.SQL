CREATE DEFINER=`root`@`localhost` PROCEDURE `rsp_ProfitandLost`(IN `Period` varchar(6),IN `RecordOwnerID` varchar(55))
BEGIN
	SELECT 
		x.KodeRekening,
		x.NamaRekening,
		x.`Level`,
		x.KodeKelompok,
		x.NamaKelompok,
		x.Posisi,
		x.FooterLaporan,
		CASE WHEN COALESCE(x.KodeRekeningInduk,'') = '' THEN x.KodeRekening ELSE x.KodeRekeningInduk END AS KodeRekeningInduk,
		CASE WHEN COALESCE(x.NamaRekeningInduk,'') = '' THEN x.NamaRekening ELSE x.NamaRekeningInduk END AS NamaRekeningInduk,
		SUM(x.Nilai) Nilai,
		SUM(x.Nilai_YTD) YTD
	FROM (
		SELECT 
				a.KodeRekening,
				b.NamaRekening,
				b.`Level`,
				b.KodeKelompok,
				c.NamaKelompok,
				c.Posisi,
				c.FooterLaporan,
				a.RecordOwnerID,
				b.KodeRekeningInduk,
				b1.NamaRekening NamaRekeningInduk,
				(CASE WHEN c.Posisi = 1 THEN MutasiKredit - MutasiDebet ELSE SaldoAkhir END) Nilai,
				0 Nilai_YTD
		FROM saldorekening a
		LEFT JOIN rekeningakutansi b on a.KodeRekening = b.KodeRekening and a.RecordOwnerID = b.RecordOwnerID
		LEFT JOIN rekeningakutansi b1 on b.KodeRekeningInduk = b1.KodeRekening and b.RecordOwnerID = b1.RecordOwnerID
		LEFT JOIN kelompokrekening c on b.KodeKelompok = c.id and b.RecordOwnerID = c.RecordOwnerID
		LEFT JOIN (
			SELECT 
				cls.KodeRekening,
				SUM(CASE WHEN cls.Posisi = 1 THEN cls.Debit - Kredit ELSE cls.Debit + cls.Kredit end) Saldo
			FROM (
				SELECT 
					x.NoTransaksi,
					x.KodeRekening,
					z.NamaRekening,
					z1.Posisi,
					x.DK,
					CASE WHEN x.DK = 1 THEN x.Jumlah ELSE 0 END AS Debit,
					CASE WHEN x.DK = 2 THEN x.Jumlah ELSE 0 END AS Kredit
				FROM detailjurnal x
				LEFT JOIN headerjurnal y on x.NoTransaksi = y.NoTransaksi and x.RecordOwnerID = y.RecordOwnerID
				LEFT JOIN rekeningakutansi z on x.KodeRekening = z.KodeRekening and z.RecordOwnerID = z.RecordOwnerID
				LEFT JOIN kelompokrekening z1 on z.KodeKelompok = z1.id and z.RecordOwnerID = z1.RecordOwnerID
				WHERE CAST(CONCAT(y.Periode,'01') AS DATE) = CAST(CONCAT(Period,'01') AS DATE)
				AND x.KodeTransaksi = -3
			) cls
			GROUP BY cls.KodeRekening
		) d ON a.KodeRekening = d.KodeRekening
		WHERE CAST(CONCAT(a.Periode,'01') AS DATE) = CAST(CONCAT(Period,'01') AS DATE) AND c.Kelompok = 2
		and a.RecordOwnerID = RecordOwnerID
		UNION ALL
		SELECT 
				a.KodeRekening,
				b.NamaRekening,
				b.`Level`,
				b.KodeKelompok,
				c.NamaKelompok,
				c.Posisi,
				c.FooterLaporan,
				a.RecordOwnerID,
				b.KodeRekeningInduk,
				b1.NamaRekening NamaRekeningInduk,
				0 Nilai,
				SUM(CASE WHEN c.Posisi = 1 THEN MutasiKredit -MutasiDebet ELSE SaldoAkhir END) Nilai_YTD
		FROM saldorekening a
		LEFT JOIN rekeningakutansi b on a.KodeRekening = b.KodeRekening and a.RecordOwnerID = b.RecordOwnerID
		LEFT JOIN rekeningakutansi b1 on b.KodeRekeningInduk = b1.KodeRekening and b.RecordOwnerID = b1.RecordOwnerID
		LEFT JOIN kelompokrekening c on b.KodeKelompok = c.id and b.RecordOwnerID = c.RecordOwnerID
		LEFT JOIN (
			SELECT 
				cls.KodeRekening,
				SUM(CASE WHEN cls.Posisi = 1 THEN cls.Debit - Kredit ELSE cls.Debit + cls.Kredit end) Saldo
			FROM (
				SELECT 
					x.NoTransaksi,
					x.KodeRekening,
					z.NamaRekening,
					z1.Posisi,
					x.DK,
					CASE WHEN x.DK = 1 THEN x.Jumlah ELSE 0 END AS Debit,
					CASE WHEN x.DK = 2 THEN x.Jumlah ELSE 0 END AS Kredit
				FROM detailjurnal x
				LEFT JOIN headerjurnal y on x.NoTransaksi = y.NoTransaksi
				LEFT JOIN rekeningakutansi z on x.KodeRekening = z.KodeRekening and x.RecordOwnerID = z.RecordOwnerID
				LEFT JOIN kelompokrekening z1 on z.KodeKelompok = z1.id and z.RecordOwnerID = z1.RecordOwnerID
				WHERE CAST(CONCAT(y.Periode,'01') AS DATE) BETWEEN CAST(CONCAT(LEFT(Period,4),'01','01') AS DATE) and CAST(CONCAT(Period,'01') AS DATE)
				AND x.KodeTransaksi = -3
			) cls
			GROUP BY cls.KodeRekening
		) d ON a.KodeRekening = d.KodeRekening
		WHERE CAST(CONCAT(a.Periode,'01') AS DATE) BETWEEN CAST(CONCAT(LEFT(Period,4),'01','01') AS DATE) AND CAST(CONCAT(Period,'01') AS DATE) AND c.Kelompok = 2
		and a.RecordOwnerID = RecordOwnerID
		GROUP BY A.KodeRekening
	)x
	GROUP BY x.KodeRekening;
		
	-- 	SELECT * FROM saldorekening
END