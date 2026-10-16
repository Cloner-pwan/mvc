let customers = async () => {
    let body = document.querySelector(".data");
    let req = await fetch("http://localhost:2004/Api/products");
    let res = await req.json();
    console.log(res);
    
};

export default customers;
