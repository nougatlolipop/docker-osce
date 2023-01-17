<tr>
    <?php if (isset($_GET['keyword'])) : ?>
        <?php if ($_GET['keyword'] != "") : ?>
            <td colspan="<?= $jumlahSpan; ?>" align="center">Pencarian "<?= $_GET['keyword'] ?>" Tidak Ditemukan</td>
        <?php else : ?>
            <td colspan="<?= $jumlahSpan; ?>" align="center">Data Tidak Ditemukan</td>
        <?php endif ?>
    <?php else : ?>
        <td colspan="<?= $jumlahSpan; ?>" align="center">Data Tidak Ditemukan</td>
    <?php endif ?>
</tr>