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

    /* Toast Style */
    .toast-success {
      position: fixed;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%) translateY(100%);
      background-color: #2e7d32; /* Darker green */
      color: white;
      padding: 15px 25px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      font-size: 16px;
      opacity: 0;
      z-index: 9999;
      transition: transform 0.5s ease, opacity 0.5s ease;
      pointer-events: none;
    }

    /* Show Animation */
    .toast-success.show {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }

    /* Hide Animation */
    .toast-success.hide {
      opacity: 0;
      transform: translateX(-50%) translateY(100%);
    }

    @media (max-width: 900px) {
      .grid {
        grid-template-columns: repeat(1, 1fr);
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
    @forelse ($items as $todo)
      <div class="card" data-id="{{ $todo->id }}">
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
          <img src="{{ asset('assets/img/pen.png') }}" onclick="openForm(this.closest('.card'))" style="cursor: pointer; width: 30px; height: 30px;">
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

      <form id="todoForm" method="POST" onsubmit="submitTodo(event)">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST">
        <input type="hidden" name="id" id="todo_id" value="">

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

  <div id="confirmDeleteModal" class="modal">
    <div class="modal-content">
      <h2 style="color: #dc3545;">Delete To-Do?</h2>
      <p>Are you sure you want to delete this to-do?</p>
      <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
        <button onclick="closeDeleteModal()" style="background: #6c757d;">Cancel</button>
        <form id="deleteForm" method="POST" style="margin: 0;">
          @csrf
          @method('DELETE')
          <button type="submit" style="background: #dc3545;">Delete</button>
        </form>
      </div>
    </div>
  </div>

  <div id="errorModal" class="modal">
    <div class="modal-content" style="text-align: center;">
      <h3 style="color: #dc3545;">Failed To Save</h3>
      <p>The input Field is still empty</p>
      <button onclick="closeErrorModal()" style="margin-top: 20px; background: #dc3545;">OK</button>
    </div>
  </div>

  <div id="alertModal" class="modal">
    <div class="modal-content" style="text-align: center;">
      <h3 style="color: #dcb835;">Warning!</h3>
      <p>the to-do item must not be less than 1!</p>
      <button onclick="closeAlertModal()" style="margin-top: 20px; background: #c9bb1f;">OK</button>
    </div>
  </div>

  <div id="toastNotification" class="toast-success"></div>

  <script>
    let isGrid = true;
    let editTarget = null;

    window.onload = function () {
      updateEmptyMessage();
    };

    function toggleMenu() {
      document.getElementById('menuContainer').classList.toggle('active');
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
      const form      = document.getElementById('todoForm');
      const methodIn  = document.getElementById('formMethod');
      const idInput   = document.getElementById('todo_id');
      const titleIn   = document.getElementById('title');
      const container = document.getElementById('todoInputsContainer');

      if (editCard) {
        // --- MODE EDIT ---
        const id       = editCard.dataset.id;
        const title    = editCard.querySelector('h3').innerText;
        const lines    = Array.from(editCard.querySelectorAll('.todo-lines label'))
                              .map(l => l.textContent.trim());

        document.getElementById('formTitle').innerText = 'Edit To-Do';
        form.action  = `/user/home/${id}`;               // route update
        methodIn.value = 'PUT';
        idInput.value  = id;
        titleIn.value  = title;

        // isi ulang input list
        container.innerHTML = '';
        lines.forEach((line,i) => {
          const inp = document.createElement('input');
          inp.type        = 'text';
          inp.name        = 'to_do_content[]';
          inp.className   = 'todo-input';
          inp.placeholder = `To-Do Item ${i+1}`;
          inp.value       = line;
          container.appendChild(inp);
        });

      } else {
        // --- MODE ADD ---
        document.getElementById('formTitle').innerText = 'Add To-Do';
        form.action      = '{{ route("user.add-todo") }}';
        methodIn.value   = 'POST';
        idInput.value    = '';
        titleIn.value    = '';
        container.innerHTML = `
          <input type="text" name="to_do_content[]" placeholder="To-Do Item 1" class="todo-input" />
        `;
      }

      document.getElementById('todoModal').style.display = 'flex';
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

    function editTodo(button, id) {
      const card = button.closest('.card');
      openForm(card, id);
    }

    function removeTodoInput() {
      const container = document.getElementById("todoInputsContainer");
      if (container.children.length > 1) {
        container.removeChild(container.lastElementChild);
      } else {
        showAlertModal();
      }
    }

    function submitTodo(event) {
      event.preventDefault(); // Mencegah reload

      const title = document.getElementById('title').value.trim();
      const inputs = document.querySelectorAll('.todo-input');
      const lines = Array.from(inputs).map(input => input.value.trim()).filter(v => v !== "");

      if (!title || lines.length === 0) {
        showErrorModal();
        return;
      }

      const form = document.getElementById('todoForm');

      // Pastikan tidak ada input to_do_content[] duplikat
      const oldInputs = form.querySelectorAll('input[name="to_do_content[]"]');
      oldInputs.forEach(input => input.remove());

      // Tambahkan input judul (title)
      let titleInput = form.querySelector('input[name="title"]');
      if (!titleInput) {
        titleInput = document.createElement('input');
        titleInput.type = 'hidden';
        titleInput.name = 'title';
        form.appendChild(titleInput);
      }
      titleInput.value = title;

      // Tambahkan input to_do_content[]
      lines.forEach(line => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'to_do_content[]';
        input.value = line;
        form.appendChild(input);
      });

      form.submit();
    }

    function deleteTodo(button) {
      const card = button.closest('.card');
      const todoId = card.dataset.id;

      const deleteForm = document.getElementById('deleteForm');
      deleteForm.action = `/user/home/${todoId}`;

      document.getElementById('confirmDeleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
      document.getElementById('confirmDeleteModal').style.display = 'none';
    }

    function showErrorModal() {
      document.getElementById('errorModal').style.display = 'flex';
    }

    function closeErrorModal() {
      document.getElementById('errorModal').style.display = 'none';
    }

    function showAlertModal() {
      document.getElementById('alertModal').style.display = 'flex';
    }

    function closeAlertModal() {
      document.getElementById('alertModal').style.display = 'none';
    }

    window.addEventListener('click', e => {
      if (e.target.id === 'todoModal') closeForm();
      if (e.target.id === 'confirmDeleteModal') closeDeleteModal();
      if (e.target.id === 'alertModal') closeAlertModal();
      if (e.target.id === 'errorModal') closeErrorModal();
    });

    function updateEmptyMessage() {
      const todoList = document.getElementById("todoList");
      const emptyMessage = document.getElementById("emptyMessage");
      emptyMessage.style.display = todoList.children.length === 0 ? "block" : "none";
    }

    function showToast(message = "Action successful!", duration = 3000) {
      const toast = document.getElementById("toastNotification");
      toast.textContent = message;
      toast.classList.add("show");
      toast.classList.remove("hide");

      setTimeout(() => {
        toast.classList.add("hide");
        toast.classList.remove("show");
      }, duration);
    }

    window.onload = function () {
      updateEmptyMessage();
    };
  </script>

</body>
  @if (session('toast'))
  <script>
    window.addEventListener('DOMContentLoaded', function () {
      showToast(@json(session('toast')));
    });
  </script>
  @endif
</html>
