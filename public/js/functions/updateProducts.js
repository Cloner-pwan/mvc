let updateProducts = async () => {
  let body = {
    colsName: ['ProductName'],
    data: ['huawei y8p BLUE'],
  };

  let config = {
    method: "PATCH",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(body),
  };

  let req = await fetch("http://localhost:2004/Api/update/products/1", config);
  
  console.log("Status: ", req.status);
  console.log("returned : ", await req.text());

};

export default updateProducts;
