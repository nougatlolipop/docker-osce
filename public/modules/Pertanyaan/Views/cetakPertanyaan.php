<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= 'Skenario dan Tugas ' . $nama; ?></title>
</head>

<body>
    <?php $dataPertanyaan = array_combine(range(1, count($pertanyaan)), array_values($pertanyaan)); ?>
    <?php foreach ($dataPertanyaan as $dtKey => $data) : ?>
        <?php if ($data->status == 'Act') : ?>
            <table>
                <tbody>
                    <tr>
                        <th style="text-align: left">
                            <h3><?= 'Station ' . $data->station ?></h3>
                        </th>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <th style="text-align: left"><strong>Skenario Klinik</strong></th>
                    </tr>
                    <tr>
                        <td><?= ($data->skenario == null) ? 'Skenario belum dibuat' : $data->skenario; ?></td>
                    </tr>
                    <?php for ($i = 0; $i < 4; $i++) : ?>
                        <tr>
                            <td></td>
                        </tr>
                    <?php endfor ?>
                    <tr>
                        <th style="text-align: left"><strong>Tugas:</strong></th>
                    </tr>
                    <?php $no = 1 ?>
                    <?php foreach ($data->detail as $key => $dtPertanyaan) :  ?>
                        <?php if ($dtPertanyaan->pertanyaan != null) : ?>
                            <tr>
                                <td><?= $no++ . '. ' . $dtPertanyaan->pertanyaan ?></td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                </tbody>
            </table>
            <table>
                <tbody>
                    <?php for ($i = 0; $i < 5; $i++) : ?>
                        <tr>
                            <td></td>
                        </tr>
                    <?php endfor ?>
                </tbody>
            </table>
            <?php end($dataPertanyaan) ?>
            <?php $key = key($dataPertanyaan) ?>
            <?php if ($key != $dtKey) : ?>
                <p <?= ($dtKey % 2 == 0) ? 'style="page-break-after: always;"' : '' ?>>&nbsp;</p>
            <?php endif ?>
        <?php endif ?>
    <?php endforeach ?>
</body>

</html>