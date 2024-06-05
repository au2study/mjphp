<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>course-upload</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .editor {
      min-height: 200px;
    }

    .card-body {
      img {
        display: block;
        width: 100%;

        @media (min-width: 992px) {
          height: 300px;
          width: auto;
        }
      }
    }

    .modal-body {
      display: flex;
      align-items: start;
      flex-wrap: wrap;
      gap: 10px;

      img {
        width: 100px;
        height: 100px;
        object-fit: cover;
      }
    }

    #fileInput {
      display: none;
    }
  </style>

  <?php include("../css_mj.php"); ?>
</head>

<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-4">
        <form action="course-upload-test.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="course_name" class="form-label">*課程名稱</label>
            <input type="text" class="form-control" id="course_name" name="course_name" required>
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">*課程價格</label>
            <input type="text" class="form-control" id="price" name="price" required>
          </div>
          <div class="mb-3">
            <label for="on_datetime" class="form-label">*上架時間</label>
            <input type="date" class="form-control" id="on_datetime" name="on_datetime" required>
          </div>
          <div class="mb-3">
            <label for="off_datetime" class="form-label">*下架時間</label>
            <input type="date" class="form-control" id="off_datetime" name="off_datetime" required>
          </div>
          <div class="mb-3">
            <!-- <label for="file" class="form-label">*選擇檔案</label>
                        <input type="file" class="form-control" id="file" name="file" required> -->
          </div>
          <button type="submit" class="btn btn-info">送出</button>
        </form>
      </div>

      <div class="col-lg-8">
        <div class="col row-cols-1 row-cols-md-2 g-3">
          <h1>插入圖片</h1>
          <div class="card">
            <div class="card-header d-flex justify-content-end">
              <div class="btn btn-primary btn-sm btn-selector">選擇圖片</div>
              <div class="btn btn-secondary btn-sm ms-2 btn-upload">上傳圖片</div>
            </div>
            <div class="card-body editor" contenteditable>description</div>
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="imgModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5">請選擇圖片</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 上傳檔案輸入欄位（隱藏，用 js 觸發） -->
  <input type="file" id="fileInput">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    const btnSelector = document.querySelector(".btn-selector");
    const btnUpload = document.querySelector(".btn-upload");
    const imgContainer = document.querySelector(".modal-body");
    const fileInput = document.querySelector("#fileInput");

    const imgSelector = new bootstrap.Modal('#imgModal', {
      backdrop: "static"
    });

    imgContainer.addEventListener("click", e => {
      if (e.target instanceof HTMLImageElement) {
        const path = e.target.getAttribute("src");
        const img = document.createElement('img');
        img.src = path;
        // 將圖片插入到游標所在位置
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
          const range = selection.getRangeAt(0);
          range.deleteContents();
          range.insertNode(img);
        }
        imgSelector.hide();
      }
    });

    btnSelector.addEventListener("click", async () => {
      try {
        const response = await fetch("./getImagesData.php");
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const imgDatas = await response.json();
        imgContainer.innerHTML = "";
        imgDatas.forEach(img => {
          const tmp = `<img src="./uploadmj/${img}">`;
          imgContainer.innerHTML += tmp;
        })
        imgSelector.show();
      } catch (err) {
        console.error("Fetch error: ", err);
      }
      imgSelector.show();
    });

    btnUpload.addEventListener("click", () => {
      fileInput.click();
    });

    fileInput.addEventListener("change", async () => {
      const file = fileInput.files[0];
      if (file) {
        const formData = new FormData();
        formData.append("file", file);
        try {
          const response = await fetch("./doUpload-mj.php", {
            method: "POST",
            body: formData
          });
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const result = await response.json();
          if (result.success) {
            const img = document.createElement('img');
            img.src = `./uploadmj/${result.filename}`;
            // 將圖片插入到游標所在位置
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
              const range = selection.getRangeAt(0);
              range.deleteContents();
              range.insertNode(img);
            }
          } else {
            console.error("Upload error: ", result.message);
          }
        } catch (err) {
          console.error("Upload error: ", err);
        }
      }
    });
  </script>
</body>

</html>