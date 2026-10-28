let data = () => {
  let form = document.querySelector("#productForm");
  let message = document.querySelector("#message");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    let form_data = new FormData(form);
    let data = Object.fromEntries(form_data);
    console.log(data);
    const btn = form.querySelector("button");
    btn.disabled = true;

    let config = {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    };

    try {
      let req = await fetch(`http://localhost:2004/Api/addProducts`, config);
      console.log("Status: ", req.status);
      console.log("Respons: ", await req.text());
      if (req.ok) {
        btn.disabled = false;
      }
    } catch (error) {
        throw new error;
    }

    // e.preventDefault();
    // let form_data = new FormData(form);
    // const data = Object.fromEntries(form_data);
    // console.log(data);
  });
};

export default data;
