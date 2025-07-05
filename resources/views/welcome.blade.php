<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Formulario Crear Cliente</title>
</head>
<body>

<h2>Crear Nuevo Cliente</h2>

<form id="clienteForm">
  <label>Nombre:</label><br>
  <input type="text" name="nombre" required maxlength="50"><br><br>

  <label>Apellido:</label><br>
  <input type="text" name="apellido" required><br><br>

  <label>RUC:</label><br>
  <input type="text" name="ruc" required maxlength="100"><br><br>

  <label>Email:</label><br>
  <input type="email" name="email" maxlength="100"><br><br>

  <label>Dirección:</label><br>
  <input type="text" name="direccion" maxlength="255"><br><br>

  <label>Razón Social:</label><br>
  <input type="text" name="razon_social" maxlength="255"><br><br>

  <label>Fecha de Nacimiento:</label><br>
  <input type="date" name="fecha_nacimiento"><br><br>

  <label>Teléfono:</label><br>
  <input type="text" name="telefono" maxlength="255"><br><br>

  <button type="submit">Crear Cliente</button>
</form>

<script>
document.getElementById('clienteForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('http://apifactura.test/api/clientes', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Basic ' + btoa('admin:admin')
        },
        body: formData
        })
  .then(response => response.json())
  .then(data => {
    alert('Respuesta del servidor: ' + JSON.stringify(data));
  })
  .catch(error => {
    alert('Error: ' + error);
  });
});
</script>
</body>
</html>
