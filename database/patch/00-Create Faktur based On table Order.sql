INSERT INTO fakturpenjualanheader
SELECT 
	DATE_FORMAT(a.TglTransaksi, '%Y%m') As Periode, 
    'POS' AS Transaksi,
    CONCAT('POS-', a.NoTransaksi,'RI') AS NoTransaksi,
    a.TglPencatatan as TglTransaksi,
    a.TglTransaksi as TglJatuhtempo,
    'POS' AS NoReff,
    a.KodePelanggan,
    15 as KodeTermin,
    0 as Termin,
    a.DurasiPaket * COALESCE(d.HargaNormal,0) as TotalTransaksi,
    0 as Potongan, 
    0 as pajak, 
    a.DurasiPaket * COALESCE(d.HargaNormal,0) as TotalPembelian,
    0 as TotalRetur,
    a.DurasiPaket * COALESCE(d.HargaNormal,0) as TotalPembayaran,
    0 as Pembulatan, 
    'C' as Status,
    'Re Inport by System',
    0 as Posted,
    115 as MetodeBayar,
    '' as reffPembayaran,
    a.KodeSales,
    'SYSTEM' AS CreatedBy,
    '' as UpdatedBy,
    '' as TipeOrder,
    '' as NomorMeja,
    0 as PajakHiburan,
    0 as BiayaLayanan,
    '' as SyaratDanKetentuan,
    'CL0009' as RecordOwnerID,
    now() as created_at,
    now as updated_at
FROM tableorderheader a 
LEFT JOIN fakturpenjualandetail b on a.NoTransaksi = b.BaseReff and a.RecordOwnerID = b.RecordOwnerID
LEFT JOIN fakturpenjualanheader c on b.NoTransaksi = c.NoTransaksi and b.RecordOwnerID = c.RecordOwnerID
LEFT JOIN pakettransaksi d on a.paketid = d.id and a.RecordOwnerID = d.RecordOwnerID
WHERE a.RecordOwnerID = 'CL0009'
AND c.NoTransaksi IS NULL 
ORDER BY a.created_at DESC;

INSERT INTO fakturpenjualandetail
SELECT DISTINCT
    CONCAT('POS-', a.NoTransaksi,'-RI') AS NoTransaksi,
    a.NoTransaksi,
    0 NoUrut,
    -1 BaseLine,
    'JS0001' as KodeItem,
    a.DurasiPaket as Qty,
    a.DurasiPaket as QtyKonversi,
    0 QtyRetur,
    a.JenisPaket,
    COALESCE(d.HargaNormal,0) as Harga,
    0 as diskon,
    a.DurasiPaket * COALESCE(d.HargaNormal,0) as HargaNet,
    'O' AS LineStatus,
    'UMM' AS Gudang,
    '' as Keterangan,
    0 as VatPercent,
    COALESCE(d.HargaNormal,0) as HPP,
   'CL0009' AS RecordOwnerID,
   0 AS Pajak,
   0 as PajakHiburan,
   0 as vattotal,
   now(),
   now()
FROM tableorderheader a 
LEFT JOIN fakturpenjualandetail b on a.NoTransaksi = b.BaseReff and a.RecordOwnerID = b.RecordOwnerID
LEFT JOIN fakturpenjualanheader c on b.NoTransaksi = c.NoTransaksi and b.RecordOwnerID = c.RecordOwnerID
LEFT JOIN pakettransaksi d on a.paketid = d.id and a.RecordOwnerID = d.RecordOwnerID
WHERE a.RecordOwnerID = 'CL0009'
and c.NoTransaksi IS NULL
ORDER BY a.created_at DESC;

SELECT * FROM fakturpenjualanheader WHERE RecordOwnerID = 'CL0009' ORDER BY created_at DESC;