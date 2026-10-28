let employee = async () => {
  let config = {
    method: "GET",
    Headers: { "Content-Type": "application/json" },
  };

  let req = await fetch(`http://localhost:2004/Api/employee?limit=5&offset=2`, config);
  let res = await req.json();
  console.log(res);
  
};
export default employee;
