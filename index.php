<?php 
require 'db_conn.php';
?>

<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css'><link rel="stylesheet" href="./style.css">

</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-custom navbar-mainbg">
        <a class="navbar-brand navbar-logo" href="#">To-Do List</a>
        <button class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
                <li class="nav-item active">
                    <a class="nav-link" href="javascript:void(0);"><i class="fas fa-clone"></i>List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="far fa-folder"></i>Folder</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="far fa-calendar-alt"></i>Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);"><i class="fa fa-sign-in"></i>Sign In</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Content -->
    <div class="row">
        <div class="side">
            <h2>What do you need to do?</h2>
            <div class="adding" style="height:200px;">
                
            <div class="add-section">
                <form action="app/add.php" method="POST" autocomplete="off">
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                    <input type="text" 
                        name="title" 
                        style="border-color: #ff6666"
                        placeholder="This field is required" />
                    <button type="submit">ADD NEW TASK</button>
    
                <?php }else{ ?>
                    <input type="text" 
                        name="title" 
                        placeholder="" />
                    <button type="submit">ADD NEW TASK</button>
                <?php } ?>
                </form>
            </div>
        </div>
    </div>
    <div class="main">
        <h2>Your To-Do List</h2>
        <div class="fakeimg" style="height:200px;">
  
        <?php 
            $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
        ?>
            <div class="show-todo-section">
                <?php if($todos->rowCount() <= 0){ ?>
                <?php } ?>
    
                <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="todo-item">
                        <span id="<?php echo $todo['id']; ?>"
                                class="remove-to-do">x</span>
                        <?php if($todo['checked']){ ?> 
                            <input type="checkbox"
                                    class="check-box"
                                    data-todo-id ="<?php echo $todo['id']; ?>"
                                    checked />
                            <h2 class="checked"><?php echo $todo['title'] ?></h2>
                        <?php }else { ?>
                            <input type="checkbox"
                                    data-todo-id ="<?php echo $todo['id']; ?>"
                                    class="check-box" />
                            <h2><?php echo $todo['title'] ?></h2>
                        <?php } ?>
                        <br>
                        <small>created: <?php echo $todo['date_time'] ?></small> 
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js'></script><script  src="./script.js"></script>

    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                
                $.post("app/remove.php", 
                    {
                        id: id
                    },
                    (data)  => {
                        if(data){
                            $(this).parent().hide(600);
                        }
                    }
                );
            });

            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('app/check.php', 
                    {
                        id: id
                    },
                    (data) => {
                        if(data != 'error'){
                            const h2 = $(this).next();
                            if(data === '1'){
                                h2.removeClass('checked');
                            }else {
                                h2.addClass('checked');
                            }
                        }
                    }
                );
            });
        });
    </script>

</body>
</html>
