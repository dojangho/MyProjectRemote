<!DOCTYPE html>
<html lang="ko">

<head>
  
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, inital-scale=1.0">
  <title>Jangho's PortPolio</title>
  
  <link rel="stylesheet" href="css/editor.css" type="text/css" charset="utf-8"/>
  <link rel="stylesheet" href="css/style.css" type="text/css"/>
  
  <script src="../js/editor_loader.js?environment=development" type="text/javascript" charset="utf-8"></script>
  
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
  
  <script type="text/javascript">
  function saveContent() {
        if(jQuery("#title").val() == "") {
            alert("제목을 입력해 주세요.");
            jQuery("#title").focus();
            return;
        }

        Editor.save(); // 이 함수를 호출하여 글을 등록하면 된다.
    }
  </script>

</head>

<body>