const productos = globalProductos;

const renderProductos = () => {
  const tbody = document.querySelector("tbody");
  tbody.innerHTML = "";

  productos.forEach((producto) => {
    const tr = document.createElement("tr");
    const tdNombre = document.createElement("td");
    const tdPrecio = document.createElement("td");
    const tdCantidad = document.createElement("td");
    const tdSubtotal = document.createElement("td");
    const tdAcciones = document.createElement("td");

    tdNombre.textContent = producto.nombre;
    tdPrecio.textContent = producto.precio.toFixed(2);
    tdCantidad.textContent = producto.cantidad;
    tdSubtotal.textContent = (producto.precio * producto.cantidad).toFixed(2);

    // Botón para eliminar el producto del carrito
    const btnEliminar = document.createElement("button");
    btnEliminar.classList.add("btn", "btn-danger", "btn-sm");
    btnEliminar.textContent = "Eliminar";
    btnEliminar.addEventListener("click", () => {
      eliminarProducto(producto.idVenta);
    });

    // Actualizar la cantidad del producto en el carrito
    const inputCantidad = document.createElement("input");
    inputCantidad.type = "number";
    inputCantidad.min = "1";
    inputCantidad.value = producto.cantidad;
    inputCantidad.addEventListener("change", () => {
      actualizarCantidad(producto.idVenta, parseInt(inputCantidad.value));
    });

    tdAcciones.appendChild(btnEliminar);
    tdAcciones.appendChild(inputCantidad);

    tr.appendChild(tdNombre);
    tr.appendChild(tdPrecio);
    tr.appendChild(tdCantidad);
    tr.appendChild(tdSubtotal);
    tr.appendChild(tdAcciones);

    tbody.appendChild(tr);
  });

  actualizarTotales();
};

const actualizarTotales = () => {
  let subtotal = 0;
  productos.forEach((producto) => {
    subtotal += producto.precio * producto.cantidad;
  });

  const total = subtotal;

  document.getElementById("subtotal").textContent = subtotal.toFixed(2);
  document.getElementById("total").textContent = total.toFixed(2);
};

const eliminarProducto = (idVenta) => {
  // eliminar el producto del carrito
  // Actualizar la interfaz después de eliminar el producto
  const indexProducto = productos.findIndex((producto) => producto.idVenta === idVenta);
  if (indexProducto !== -1) {
    productos.splice(indexProducto, 1);
    renderProductos();
  }
};

const actualizarCantidad = (idVenta, nuevaCantidad) => {
  //actualizar la cantidad del producto en el carrito 
  // Actualizar la interfaz después de actualizar la cantidad
  const producto = productos.find((producto) => producto.idVenta === idVenta);
  if (producto) {
    producto.cantidad = nuevaCantidad;
    renderProductos();
  }
};

renderProductos();

const pagarButton = document.getElementById("pagar");
pagarButton.addEventListener("click", () => {
  // lógica de pago
  alert("Pago realizado con éxito!");
});
