let customers = async () => {
    let body = document.querySelector(".data");
    let req = await fetch("http://localhost:2004/Api/customers?limit=10&offset=2");
    let res = await req.json();
    console.log(res);
    
};

export default customers;
