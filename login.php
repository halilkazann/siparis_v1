<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="css/input.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
<div class="flex items-center min-h-full max-h-full relative">


    <div class="z-30 w-96 absolute h-100 rota p-10  bg-black flex flex-col justify-center  items-center rounded-md opacity-30 hover:opacity-80 shadow-2xl shadow-black transition-all duration-150">


        <form action="loginControl.php" method="post">
            <input class="w-80 h-11 border-b-2 border-gray-400  font-light outline-none p-4 mb-6" type="text" id="mail" placeholder="Web Sitesi" name="webSite">
            <input class=" w-80 h-11 border-b-2 border-gray-400 font-light outline-none p-4 mb-6" name="kullanici"  type="text" id="user" placeholder="Kullanıcı Adı" >
                <div class="relative w-80">
                    <input class="w-80 h-11 border-b-2 border-gray-400  font-light outline-none p-4" type="password" placeholder="Şifre"  id="password" name="pass">
                    <button class="text-gray-400 absolute right-1 top-3" onclick="togglePasswordVisibility()"><i class="fa-regular fa-eye"></i></button>
                </div>
            <input class="mt-10 bg-blue-500 text-white font-light h-11 w-80 cursor-pointer text-lg hover:bg-blue-500 transition-all duration-100" type="submit" value="Giriş Yap">
        </form>



    </div>


<div class="w-full h-full absolute z-20 bg-black opacity-0"></div>
    <div class="h-screen w-screen z-10" id="slideshow">
        <img  src="images/image.jpg" alt="">
    </div>

</div>
<script src="js/changeImg.js"></script>
<script src="js/showpassword.js"></script>
<script src="https://kit.fontawesome.com/de0713e58b.js" crossorigin="anonymous"></script>
</body>
</html>

