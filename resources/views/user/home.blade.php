<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>To-Do List</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      color: #333;
      min-height: 100vh;
      padding: 40px;
      position: relative;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
      margin-bottom: 30px;
    }

    .toggle-view {
      background: white;
      border: none;
      border-radius: 8px;
      padding: 5px;
      cursor: pointer;
    }

    .list {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 15px;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      gap: 10px;
      height: 300px;
      position: relative;
      overflow: hidden;
    }

    .card-content {
      overflow-y: auto;
      flex-grow: 1;
    }

    .card h3 {
      font-size: 1rem;
      color: #2575fc;
    }

    .card small {
      color: #777;
      position: absolute;
      bottom: 10px;
      left: 20px;
    }

    .card .todo-lines label {
      display: block;
      margin-top: 5px;
      cursor: pointer;
    }

    .card .actions {
      position: absolute;
      top: 10px;
      right: 10px;
      display: flex;
      gap: 5px;
    }

    .card .actions button {
      background: transparent;
      border: none;
      font-size: 18px;
      cursor: pointer;
      color: #999;
    }

    .add-btn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: white;
      border: none;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      font-size: 30px;
      color: #2575fc;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .modal {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.4);
      display: none;
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 12px;
      width: 90%;
      max-width: 400px;
    }

    .modal-content h2 {
      margin-bottom: 15px;
      color: #2575fc;
    }

    .todo-input {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .todo-input-scroll {
      max-height: 200px;
      overflow-y: auto;
      padding-right: 5px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      padding: 10px;
      background: #f9f9f9;
    }

    .modal-content button {
      background: #2575fc;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
    }

      /* Burger Menu */
      .menu-container {
      position: relative;
    }

    .menu-button {
      background: none;
      border: none;
      color: white;
      font-size: 24px;
      cursor: pointer;
    }

    .menu-dropdown {
      display: none;
      position: absolute;
      top: 35px;
      right: 0;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      z-index: 999;
      width: 200px;
    }

    .menu-dropdown a {
      display: block;
      padding: 10px 15px;
      text-decoration: none;
      color: #333;
      white-space: nowrap;
    }

    .menu-dropdown a:hover {
      background: #f0f0f0;
    }

    .menu-container.active .menu-dropdown {
      display: block;
    }

    @media (max-width: 900px) {
      .grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
  </style>
</head>
<body>

  <header>
    <h1>MinimoTask | Welcome {{ $user->username }}</h1>
    <div class="menu-container" id="menuContainer">
      <button class="menu-button" onclick="toggleMenu()">☰</button>
      <div class="menu-dropdown">
        <button class="toggle-view" onclick="toggleView()" title="Toggle View" style="width: 100%; text-align: center; background: none; border: none; padding: 10px 15px; cursor: pointer; font-size: 20px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <img id="toggleIcon" src="{{ asset('assets/img/list.png') }}" style="width: 25px; height: 25px;">
            <p id="view-type" style="background: none; border: color: #333; width: 100%; text-align: left; cursor: pointer; font-size: 20px;">List View</p>
          </div>
        </button>
        <form action="{{ route('user.logout') }}" method="POST" style="margin: 0;">
          @csrf
          <button type="submit" style="background: rgb(220, 53, 69); border-radius: 5px; border: 1px solid rgb(0, 0, 0); color: #ffffff; width: 100%; text-align: center; padding: 10px 15px; cursor: pointer; font-size: 20px;">Logout</button>
        </form>
      </div>
    </div>
  </header>

  <div id="todoList" class="grid">
    @forelse ($item as $todo)
      <div class="card">
        <div class="card-content">
          <h3>{{ $todo->title }}</h3>
          <hr>
          <div class="todo-lines">
            @foreach (explode("\n", $todo->to_do_content) as $line)
              <label><input type="checkbox"> {{ $line }}</label>
            @endforeach
          </div>
        </div>
        <hr style="margin: 10px 0;">
        <small>Created at: {{ $todo->created_at->format('d M Y H:i') }}</small>
        <div class="actions">
          <img src="{{ asset('assets/img/pen.png') }}" onclick="editTodo(this)" style="cursor: pointer; width: 30px; height: 30px;">
          <img src="{{ asset('assets/img/bin.png') }}" onclick="deleteTodo(this)" style="cursor: pointer; width: 30px; height: 30px;">
        </div>
      </div>
    @empty
      
    @endforelse
  </div>  

  <div id="todoList" class="grid"></div>
  <p id="emptyMessage" 
    style="
      text-align:center; 
      color:#f6f6f6; 
      margin-top: 250px; 
      font-size: 25px;"
    >
      No to-do Lists has been created yet
  </p>


  <button class="add-btn" onclick="openForm()">＋</button>

  {{-- modal --}}
  <div id="todoModal" class="modal">
    <div class="modal-content">
      <h2 id="formTitle">Add To-Do</h2>

      <form action="{{ route('user.add-todo') }}" method="POST" onsubmit="submitTodo(event)">
        @csrf
        <label for="title">Title</label>
        <input type="text" id="title" name="title" placeholder="input to-do title here......" 
          style="
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;"
        />

        <label>To-Do Item List</label>
        <div id="todoInputsContainer" class="todo-input-scroll">
          <input type="text" name="to_do_content[]" placeholder="To-Do Item 1" class="todo-input" />
          <input type="text" name="to_do_content[]" placeholder="To-Do Item 2" class="todo-input" />
          <input type="text" name="to_do_content[]" placeholder="To-Do Item 3" class="todo-input" />
        </div>

        <div style="display: flex; justify-content: space-between; gap: 10px; margin-bottom: 10px;">
          <button type="button" onclick="addTodoInput()" style="flex:1; background: #4CAF50;">Add To-Do Item</button>
          <button type="button" onclick="removeTodoInput()" style="flex:1; background: #dc3545;">Delete To-Do Item</button>
        </div>

        <button type="submit" style="width: 100%;">Save</button>
      </form>

    </div>
  </div>

  <script>
    let isGrid = true;
    let editTarget = null;

    window.onload = function () {
      updateEmptyMessage();
    };

    function toggleMenu() {
      document.getElementById('menuContainer').classList.toggle('active');
    }

    function openForm(editCard = null) {
      document.getElementById('todoModal').style.display = 'flex';
      if (editCard) {
        editTarget = editCard;
        document.getElementById('formTitle').innerText = "Edit To-Do";
        document.getElementById('title').value = editCard.querySelector('h3').innerText;
        const lines = Array.from(editCard.querySelectorAll('.todo-lines label')).map(l => l.textContent.trim());
        document.getElementById('content').value = lines.join("\n");
      } else {
        editTarget = null;
        document.getElementById('formTitle').innerText = "Add To-Do";
        document.getElementById('title').value = '';
        document.getElementById('content').value = '';
      }
    }

    function toggleView() {
      const list = document.getElementById('todoList');
      isGrid = !isGrid;
      list.className = isGrid ? 'grid' : 'list';
      toggleIcon.src = isGrid
        ? '{{ asset("assets/img/list.png") }}'
        : '{{ asset("assets/img/grid.png") }}';

      document.getElementById('view-type').innerText = isGrid ? 'List View' : 'Grid View';
    }

    function openForm(editCard = null) {
      document.getElementById('todoModal').style.display = 'flex';
      const container = document.getElementById("todoInputsContainer");

      if (editCard) {
        editTarget = editCard;
        document.getElementById('formTitle').innerText = "Edit To-Do";
        document.getElementById('title').value = editCard.querySelector('h3').innerText;

        const lines = Array.from(editCard.querySelectorAll('.todo-lines label')).map(l => l.textContent.trim());
        container.innerHTML = '';
        lines.forEach((line, i) => {
          const input = document.createElement("input");
          input.type = "text";
          input.className = "todo-input";
          input.placeholder = `To-Do Item ${i + 1}`;
          input.value = line;
          container.appendChild(input);
        });
      } else {
        editTarget = null;
        document.getElementById('formTitle').innerText = "Add To-Do";
        document.getElementById('title').value = '';
        container.innerHTML = `
          <input type="text" placeholder="To-Do Item 1" class="todo-input" />
          <input type="text" placeholder="To-Do Item 2" class="todo-input" />
          <input type="text" placeholder="To-Do Item 3" class="todo-input" />
        `;
      }
    }

    function closeForm() {
      document.getElementById('todoModal').style.display = 'none';
    }

    function addTodoInput() {
      const container = document.getElementById("todoInputsContainer");
      const input = document.createElement("input");
      input.type = "text";
      input.className = "todo-input";
      input.placeholder = `To-Do Item ${container.children.length + 1}`;
      container.appendChild(input);
    }

    function removeTodoInput() {
      const container = document.getElementById("todoInputsContainer");
      if (container.children.length > 1) {
        container.removeChild(container.lastElementChild);
      } else {
        // FIXME
        alert("Minimal harus ada satu item To-Do.");
      }
    }

    function submitTodo(event) {
      event.preventDefault(); // Mencegah reload

      const title = document.getElementById('title').value.trim();
      const inputs = document.querySelectorAll('.todo-input');
      const lines = Array.from(inputs).map(input => input.value.trim()).filter(v => v !== "");

      if (!title || lines.length === 0) {
        return alert("Mohon isi semua field.");
      }

      // Buat form secara dinamis dan kirim POST ke Laravel
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '{{ route("user.add-todo") }}';

      const csrf = document.querySelector('input[name="_token"]');
      form.appendChild(csrf.cloneNode());

      const titleInput = document.createElement('input');
      titleInput.type = 'hidden';
      titleInput.name = 'title';
      titleInput.value = title;
      form.appendChild(titleInput);

      lines.forEach(line => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'to_do_content[]';
        input.value = line;
        form.appendChild(input);
      });

      document.body.appendChild(form);
      form.submit();
    }

    function deleteTodo(button) {
      if (confirm("Hapus To-Do ini?")) {
        const card = button.closest('.card');
        card.remove();
        updateEmptyMessage();
      }
    }

    function editTodo(button) {
      const card = button.closest('.card');
      openForm(card);
    }

    window.addEventListener('click', e => {
      if (e.target.id === 'todoModal') closeForm();
    });

    function updateEmptyMessage() {
      const todoList = document.getElementById("todoList");
      const emptyMessage = document.getElementById("emptyMessage");
      emptyMessage.style.display = todoList.children.length === 0 ? "block" : "none";
    }

    window.onload = function () {
      updateEmptyMessage();
    };
  </script>

</body>
</html>
