<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
    <script type="module" src="<?= JS_DIRECTORY ?>main.js" defer></script>
</head>

<body>
    <form id="productForm">
        <input name="ProductName" placeholder="Name" required>
        <input name="SupplierID" type="number" placeholder="Supplier ID">
        <input name="CategoryID" type="number" placeholder="Category ID">
        <input name="Unit" placeholder="Unit">
        <input name="Price" type="number" step="0.01" placeholder="Price" required>

        <button id="btn" type="submit">Add product</button>
        <p id="message"></p>
    </form>

    <table>
        <tbody id="productList"></tbody>
    </table>
</body>

</html>