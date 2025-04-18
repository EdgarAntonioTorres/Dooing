<?php include 'header.php'; ?>

<section class="hero">
  <h2>Organiza tu día con Dooing</h2>
  <p>Una app visual, clara y rápida para gestionar tus tareas</p>
</section>

<section class="todo-app">
  <form id="todo-form" class="todo-form">
    <input type="text" id="todo-input" placeholder="Escribe tu tarea..." required />
    <button type="submit">Agregar ➕</button>
  </form>

  <ul id="todo-list" class="todo-list"></ul>
</section>

<script>
  const form = document.getElementById("todo-form");
  const input = document.getElementById("todo-input");
  const list = document.getElementById("todo-list");

  window.addEventListener("DOMContentLoaded", () => {
    const saved = JSON.parse(localStorage.getItem("dooing-tareas")) || [];
    saved.forEach(t => addTask(t.text, t.done));
  });

  form.addEventListener("submit", e => {
    e.preventDefault();
    const text = input.value.trim();
    if (text !== "") {
      addTask(text, false);
      input.value = "";
    }
  });

  function addTask(text, done) {
    const li = document.createElement("li");
    li.className = "todo-item";
    li.innerHTML = `
      <span class="${done ? 'done' : ''}">${text}</span>
      <div class="buttons">
        <button onclick="toggleDone(this)">✔️</button>
        <button onclick="removeTask(this)">🗑️</button>
      </div>
    `;
    list.appendChild(li);
    saveTasks();
  }

  function toggleDone(btn) {
    const span = btn.closest("li").querySelector("span");
    span.classList.toggle("done");
    saveTasks();
  }

  function removeTask(btn) {
    btn.closest("li").remove();
    saveTasks();
  }

  function saveTasks() {
    const tasks = [];
    document.querySelectorAll(".todo-item").forEach(item => {
      const text = item.querySelector("span").textContent;
      const done = item.querySelector("span").classList.contains("done");
      tasks.push({ text, done });
    });
    localStorage.setItem("dooing-tareas", JSON.stringify(tasks));
  }
</script>

<?php include 'footer.php'; ?>