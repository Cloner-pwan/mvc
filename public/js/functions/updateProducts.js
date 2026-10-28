let updateProducts = async () => {
  let data = {
    Price: "1100",
  };
  let config = {
    method: "PATCH",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  };

  let req = await fetch("http://localhost:2004/Api/update/products/2", config);

  console.log("Status: ", req.status);
  console.log("returned : ", await req.text());
};

export default updateProducts;
