<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>SAÍDA</title>
</head>

<body class="bg-white-900 text-black flex items-center justify-center min-h-screen">
  <div class="bg-gray-200 p-8 rounded-lg shadow-md w-full max-w-sm">
    <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">SAIR</h2>
    <form action="/sair" method="POST">
      <div class="mb-4">
        <label for="placa" class="block text-sm font-medium text-gray-700">Placa</label>
        <input type="text" id="placa" name="placa" required
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
      </div>
      <input  type="submit" value="Registrar saída" class="w-full bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 padding:80px" >
        </input>
    </form>

  </div>
</body>

</html>
