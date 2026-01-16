<?php
include 'db.php';

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

session_start();
$id = $_SESSION['coach'];
date_default_timezone_set('America/Mexico_City');

// Obtener y formatear los parámetros de la URL
$start = isset($_GET['start']) ? date('Y-m-d H:i:s', strtotime($_GET['start'])) : null;
$end = isset($_GET['end']) ? date('Y-m-d H:i:s', strtotime($_GET['end'])) : null;

// Validar fechas
if (!$start || !$end) {
  http_response_code(400);
  echo json_encode(["error" => "Fechas inválidas"]);
  exit;
}

function generarToken16Digitos()
{
  $token = '';
  for ($i = 0; $i < 32; $i++) {
    $token .= random_int(0, 9);
  }
  return $token;
}

// CONSULTA CON FILTRO DE FECHAS 
$sql = "SELECT id, hora_inicio, hora_fin, aforo, reservados, id_disciplina, estatus 
        FROM clases 
        WHERE id_coach = ? AND hora_inicio BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $id, $start, $end);
$stmt->execute();
$result = $stmt->get_result();

$eventos = [];

while ($row = $result->fetch_assoc()) {
  $token = generarToken16Digitos();

  $timestamp_inicio = strtotime($row["hora_inicio"]);
  $cancelable = (time() - $timestamp_inicio) > 7200 ? false : true;
  $sqlF = ("SELECT nombre_disciplina FROM disciplinas WHERE id = ?");
  $stmtF = $conn->prepare($sqlF);
  $stmtF->bind_param("i", $row["id_disciplina"]);
  $stmtF->execute();
  $resultF = $stmtF->get_result();
  if ($rowF = $resultF->fetch_assoc()) {
    $n_disciplina = $rowF['nombre_disciplina'];
  } else {
    $n_disciplina = "-";
  }


  $aforo = $row['reservados'] . "/" . $row['aforo'];
  //CONSULTA DURACION DE LA CLASE
  $hora_inicio = $row['hora_inicio'];
  $hora_fin = $row['hora_fin'];

  $inicio = new DateTime($hora_inicio);
  $fin = new DateTime($hora_fin);

  // Calcula la diferencia
  $intervalo = $inicio->diff($fin);

  // Convierte todo a minutos
  $diferencia_minutos = ($intervalo->h * 60) + $intervalo->i;

  // Guarda en formato "50 min"
  $dura = $diferencia_minutos . " min";


  $name_coach = $_SESSION['nombre'];

  $estatus = '<svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto" viewBox="0 0 512 512">
                <defs><style>.ionicon { fill: #986C5D; }</style></defs>
                <title>Ellipse</title>
                <path d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z"></path>
              </svg>';

  // lista de alumnos
  $sqlA = "SELECT 
                            users.nombre, 
                            reservaciones.id AS reservacion_id, 
                            reservaciones.alumno,
                            reservaciones.notas, 
                            reservaciones.invitado,
                            reservaciones.lugar
                        FROM reservaciones 
                        INNER JOIN users ON reservaciones.alumno = users.id 
                        WHERE reservaciones.idClase = ?";

  $stmtA = $conn->prepare($sqlA);
  $stmtA->bind_param("i", $row['id']);
  $stmtA->execute();
  $resultA = $stmtA->get_result();
  // Imprimir lista
  $alumnos = '<ul style="width: 100%;">';

  while ($rowA = $resultA->fetch_assoc()) {
    $name = htmlspecialchars($rowA['nombre']);
    $idEvent = $row['id'];
    $Ndisciplina = "'" . $n_disciplina . "'";
    $a1 = $rowA['reservacion_id'];
    $a2 = $rowA['alumno'];
    $a3 = $rowA['invitado'];
    $a4 = $rowA['lugar'];
    if (!$a4 == null) {
      $lugar = "(Lugar: $a4)";
    } else {
      $lugar = "";
    }


    $asistencia = 1 + $rowA['invitado'];

    if ($rowA['notas'] !== null) {
      $nuser = $rowA['notas'];
      $nota = "notausuario('$nuser')";
      $iconota = '<button onclick="' . $nota . '"><ion-icon name="information-circle-outline" style="font-size: 2.5rem;color: var(--c2);" aria-hidden="true"></ion-icon></button>';
    } else {
      $iconota = "";
    }
    $alumnos .= '<li style="display: flex;justify-content: space-between; align-items: center;"><p>' . $name . ' (x' . $asistencia . ')' . $lugar . '</p><div style="display: flex;gap: 10px;">' . $iconota . '</div></li>';
  }
  $alumnos .= "</ul>";


  $eventos[] = [
    "id" => $row["id"],
    "title" => $n_disciplina,
    "instructor" => $name_coach,
    "invitado" => 0,
    "aforo" => $aforo,
    "estatus" => $estatus,
    "alm" => $alumnos,
    "dura" => $dura,
    "cancelable" => $cancelable,
    "start" => $row["hora_inicio"],
    "end" => $row["hora_fin"]
  ];
}

header('Content-Type: application/json');
echo json_encode($eventos);
