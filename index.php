<?php

  /* Função que varre a tabela de medicamentos e extrai os dados necessários */
  function getMedicineData()
  {
    $server = "127.0.0.1";
    $user  = "root";
    $pass    = "";
    $db = "dev_gero";

    $conn = mysqli_connect($server, $user, $pass, $db);

    $query = 'SELECT medicines.id, medicines.ean, medicines.name, medicines.active_principle, medicines.dosage, medicines.pharmaceutical_form, medicines.quantity, '
    . 'medicine_manufacturers.short_name as manufacturer_name, '
    . 'medicine_types.name as medicine_type_name '
    . 'FROM medicines '
    . 'LEFT JOIN medicine_manufacturers ON medicines.manufacturer_id = medicine_manufacturers.id '
    . 'LEFT JOIN medicine_types ON type_id = medicine_types.id '
    . 'ORDER BY medicines.name ASC';

    $result = mysqli_query($conn, $query);

    $medicine_data = array();

    while ($row = mysqli_fetch_array($result))
    {
      $medicine_data[] = array(
        'id'                  => $row["id"],
        'ean'                 => $row["ean"],
        'name'                => $row["name"],
        'short_name'          => $row["manufacturer_name"],
        'type_name'           => $row["medicine_type_name"],
        'dosage'              => $row["dosage"],
        'quantity'            => $row["quantity"],
        'active_principle'    => $row["active_principle"],
        'pharmaceutical_form' => $row["pharmaceutical_form"],
      );
    }

    return json_encode($medicine_data, JSON_UNESCAPED_UNICODE);
  }

  // echo '<pre>';
  // print_r(getMedicineData());
  // echo '</pre>';

  $file_name = 'medicines.json';

  if(file_put_contents($file_name, getMedicineData()))
  {
    echo $file_name . ' criado com sucesso!';
  }
  else
  {
    echo 'Falha ao criar arquivo ' . $file_name . ' !';
  }

?>
