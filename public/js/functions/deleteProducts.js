let deleteProduct = async () => {
  const id = 80;
  let config = {
    method: "DELETE",
    Headers: { "Content-type": "application/json" },
  };

  let req = await fetch(`http://localhost:2004/Api/delete/${id}`, config);

  console.log("Status: ", req.status);
  console.log("Respond: ", await req.text());
};

export default deleteProduct;
