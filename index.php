<?php
session_start();

if (!isset($_SESSION['todos'])) {
    $_SESSION['todos'] = [];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $newTask = trim($_POST['new_task']);
    if (!empty($newTask)) {
        $_SESSION['todos'][] = ['task' => $newTask, 'completed' => false];
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['complete'])) {
    $index = $_POST['index'];
    if (isset($_SESSION['todos'][$index])) {
        $_SESSION['todos'][$index]['completed'] = true;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $index = $_POST['index'];
    if (isset($_SESSION['todos'][$index])) {
        array_splice($_SESSION['todos'], $index, 1);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            text-align: center;
        }
        .todo-list {
            max-width: 400px;
            margin: 0 auto;
        }
        input[type="text"] {
            padding: 10px;
            width: 80%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .task-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .completed {
            text-decoration: line-through;
            color: grey;
        }
    </style>
</head>
<body>
    <div class="todo-list">
        <h2>To-Do List</h2>
        <form method="post">
            <input type="text" name="new_task" placeholder="Enter a new task" required>
            <button type="submit" name="add">Add Task</button>
        </form>

        <ul style="list-style: none; padding: 0;">
            <?php foreach ($_SESSION['todos'] as $index => $todo): ?>
                <li class="task-item">
                    <span class="<?= $todo['completed'] ? 'completed' : '' ?>">
                        <?= htmlspecialchars($todo['task']) ?>
                    </span>
                    <div>
                        <?php if (!$todo['completed']): ?>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <button type="submit" name="complete">Complete</button>
                            </form>
                        <?php endif; ?>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="index" value="<?= $index ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
