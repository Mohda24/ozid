<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form>
        <input id="title" type="text" placeholder="Title">
        <input id="content" type="text" placeholder="Content">
        <input id="category_id" type="text" placeholder="Category">
        <button id="btn-insert" type="button">Ajouter</button>
    </form>

    <br>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>content</th>
                <th>Category_id</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <script>
        function getData() {

            let myrequest = new XMLHttpRequest()
            myrequest.open("GET","api/posts.php")

            myrequest.onreadystatechange = function(){
                if(this.status == 200 && this.readyState == 4){
                    let posts = JSON.parse(this.responseText);

                    posts.forEach(post => {
                        let table = `
                        <tr>
                            <td>${post.id}</td>
                            <td>${post.title}</td>
                            <td>${post.content}</td>
                            <td>${post.category_id}</td>
                            <td>${post.date}</td>
                        </tr>
                        `
                        document.querySelector("table tbody").innerHTML += table
                    });

                }
            }

            myrequest.send()
        }
        getData()



    document.getElementById("btn-insert").addEventListener("click", function () {
    var title = document.getElementById("title").value;
    var content = document.getElementById("content").value;
    var category_id = document.getElementById("category_id").value; 


    let myrequest = new XMLHttpRequest();
    myrequest.open("POST", "api/posts.php");

    myrequest.onload = function () {
        if (myrequest.status == 200) {
            let data = JSON.parse(myrequest.responseText);
            if(data.status == false){
                alert(data.message)
            }else{
                getData()
            }
        } 

    };

    var postData = {
        title: title,
        content: content,
        category_id: category_id
    }
    var mydata=JSON.stringify(postData)
    
    myrequest.setRequestHeader("Content-Type", "application/json");
    myrequest.send(mydata);
});


    </script>
</body>
</html>