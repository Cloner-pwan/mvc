let addproducts = async () => {
  let config = {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      colsName: ["ProductName", "SupplierID", "CategoryID", "Unit", "Price"],
      data: {
        ProductName: "Iphone 15 Pro Max 2",
        SupplierID: 1,
        CategoryID: 2,
        Unit: "Box",
        Price: 2100,
      },
    }),
  };
  let req = await fetch("http://localhost:2004/Api/addProducts", config);

  console.log("Status:", req.status);
  console.log("Response:", await req.text());
};

export default addproducts;
