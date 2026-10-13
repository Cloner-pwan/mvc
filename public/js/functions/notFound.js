let notFound = () => {
  let lFollowX = 0,
    lFollowY = 0,
    x = 0,
    y = 0,
    friction = 1 / 30;

  function animate() {
    x += (lFollowX - x) * friction;
    y += (lFollowY - y) * friction;

    let translate = `translate(${x}px, ${y}px) scale(1.1)`;

    document.querySelectorAll("img").forEach((img) => {
      img.style.transform = translate;
    });

    window.requestAnimationFrame(animate);
  }

  window.addEventListener("mousemove", function (e) {
    let lMouseX = Math.max(
      -100,
      Math.min(100, window.innerWidth / 2 - e.clientX),
    );

    let lMouseY = Math.max(
      -100,
      Math.min(100, window.innerHeight / 2 - e.clientY),
    );

    lFollowX = (20 * lMouseX) / 100;
    lFollowY = (10 * lMouseY) / 100;
  });

  window.addEventListener("click", function (e) {
    let lMouseX = Math.max(
      -100,
      Math.min(100, window.innerWidth / 2 - e.clientX),
    );

    let lMouseY = Math.max(
      -100,
      Math.min(100, window.innerHeight / 2 - e.clientY),
    );

    lFollowX = (20 * lMouseX) / 100;
    lFollowY = (10 * lMouseY) / 100;
  });

  animate();
};

export default notFound;
