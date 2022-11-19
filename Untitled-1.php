


<a href="../apiclient/add_antrian.php?kddokter=<?php echo urlencode(CurrentPage()->EMPLOYEE_ID->CurrentValue).'&day'. urlencode(CurrentPage()->VISIT_DATE->CurrentValue)?>" class="btn btn-info btn-sm" role="button">Add</a>
<a href="../apiclient/task.php.php?kddokter=<?php echo urlencode(CurrentPage()->EMPLOYEE_ID->CurrentValue)?>" class="btn btn-info btn-sm" role="button">Task</a>
<a href="../apiclient/del.php?kddokter=<?php echo urlencode(CurrentPage()->EMPLOYEE_ID->CurrentValue)?>" class="btn btn-info btn-sm" role="button">Batal</a>



<script>
	function Buka(link = "") {
		window.open(link, 'newwindow', 'width=800,height=400');
		return false;
	};

</script>
<?php
if (empty(CurrentPage()->NO_SKP->CurrentValue)) {
?>
<a href="../apiclient/add_antrian.php?kddokter=<?php echo urlencode(CurrentPage()->EMPLOYEE_ID->CurrentValue).'&day'. urlencode(CurrentPage()->VISIT_DATE->CurrentValue)?>" class="btn btn-info btn-sm" id="rujukan" role="button">Ambil Rujukan</a>
<a href="../bridging/insert_sep.php?key=<?php echo urlencode(CurrentPage()->PASIEN_ID->CurrentValue) . '&pelayanan=' . urlencode(CurrentPage()->RESPONTGLPLG_DESC->CurrentValue) . '&id=' . urlencode(CurrentPage()->IDXDAFTAR->CurrentValue). '&catatan=' . urlencode(CurrentPage()->DESCRIPTION->CurrentValue). '&nosurat=' . urlencode(CurrentPage()->EDIT_SEP->CurrentValue). '&eksekutif=' . urlencode(CurrentPage()->KDPOLI_EKS->CurrentValue). '&dpjp=' . urlencode(CurrentPage()->KDDPJP->CurrentValue) . '&no=' . urlencode(CurrentPage()->NO_REGISTRATION->CurrentValue).'&poli=' . urlencode(CurrentPage()->KDPOLI->CurrentValue) ?>" class="btn btn-info btn-sm" role="button">Buat SEP</a>
<a href="../bridging/insert_skdp.php?id=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue).'&poli='.urlencode(CurrentPage()->KDPOLI->CurrentValue).'&sep='.urlencode(CurrentPage()->NO_SKP->CurrentValue).'&tgl='.urlencode(CurrentPage()->tgl_kontrol->CurrentValue).'&dpjp='.urlencode(CurrentPage()->KDDPJP->CurrentValue)?>" class="btn btn-info btn-sm" role="button">Buat Kontrol</a>
<?php } else { ?>
<a href="#" onclick="Buka('../bridging/jasper.php?id=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue).'&tipe=SEP_BPJS'?>'); return false" class="btn btn-info btn-sm" role="button">Cetak SEP </a>
<a href="#" onclick="Buka('../bridging/jasper.php?id=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue).'&tipe=SEP_BPJS_ASLI'?>'); return false" class="btn btn-info btn-sm" role="button">Cetak SEP Asli</a>
<?php } ?>

<?php if (empty(CurrentPage()->APPROVAL_RESPONAJUKAN->CurrentValue)) {?>
<a href="../apiclient/add_antrian.php?id=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue).'&day='. urlencode(CurrentPage()->VISIT_DATE->CurrentValue)?>" class="btn btn-info btn-sm" role="button">Add</a>
<?php };?>
<a href="../apiclient/task.php.php?kddokter=<?php echo urlencode(CurrentPage()->EMPLOYEE_ID->CurrentValue)?>" class="btn btn-success btn-sm" role="button">Task</a>
<a href="../apiclient/del.php?kddokter=<?php echo urlencode(CurrentPage()->EMPLOYEE_ID->CurrentValue)?>" class="btn btn-danger btn-sm" role="button">Batal</a>
