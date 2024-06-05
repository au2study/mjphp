<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>course-upload</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

    /* 全局樣式調整 */
    body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
        }

        /* 表單樣式調整 */
        .form-label {
            font-weight: bold;
        }

        /* 影片和圖片輸入欄樣式調整 */
        input[type="file"] {
            margin-bottom: 10px;
        }

        /* .editor {
            min-height: 200px;
        }

        .card-body img {
            display: block;
            width: 100%;
        }

        @media (min-width: 992px) {
            .card-body img {
                height: 300px;
                width: auto;
            }
        }

        .modal-body {
            display: flex;
            align-items: start;
            flex-wrap: wrap;
            gap: 10px;
        }

        .modal-body img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        #fileInput {
            display: none;
        } */
    </style>
    <?php include("../css_mj.php"); ?>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4">
                <form action="doCreateCourse.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="course_name" class="form-label">*課程名稱</label>
                        <input type="text" class="form-control" id="course_name" name="course_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">*課程價格</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_category_id" class="form-label">*類別 (1:gomoku, 2:mahjong, 3:go, 4:chess, 5:shogi)</label>
                        <select id="course_category_id" name="course_category_id" class="form-select" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="on_datetime" class="form-label">*上架時間</label>
                        <input type="date" class="form-control" id="on_datetime" name="on_datetime" required>
                    </div>
                    <div class="mb-3">
                        <label for="off_datetime" class="form-label">*下架時間</label>
                        <input type="date" class="form-control" id="off_datetime" name="off_datetime" required>
                    </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="file" class="form-label">*上傳影片</label>
                    <input type="file" class="form-control" id="file" name="file" accept="video/*" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">*上傳圖片</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-info">送出</button>
                </form>
            </div>
        </div>


                <!-- <div class="col-lg-8">
                <div class="col row-cols-1 row-cols-md-2 g-3">
                    <h1>插入圖片</h1>
                    <div class="card">
                        <div class="card-header d-flex justify-content-end">
                            <div class="btn btn-primary btn-sm btn-selector">選擇圖片</div>
                            <div class="btn btn-secondary btn-sm ms-2 btn-upload">上傳圖片</div>
                        </div>
                        <div class="card-body editor" contenteditable>description</div>
                    </div>
                </div> -->
                <!-- Modal -->
                <!-- <div class="modal fade" id="imgModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">請選擇圖片</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">...</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

                <!-- </form>
            </div>
        </div> -->

        <input type="file" id="fileInput">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script>
            // // 獲取按鈕選擇器元素
            // const btnSelector = document.querySelector(".btn-selector");
            // // 獲取按鈕上傳元素
            // const btnUpload = document.querySelector(".btn-upload");
            // // 獲取圖片容器元素
            // const imgContainer = document.querySelector(".modal-body");
            // // 獲取檔案輸入元素
            // const fileInput = document.querySelector("#fileInput");

            // // 創建圖片選擇器對話框
            // const imgSelector = new bootstrap.Modal('#imgModal', {
            //     backdrop: "static" // 設置背景點擊時不關閉對話框
            // });

            // // 監聽圖片容器的點擊事件
            // imgContainer.addEventListener("click", e => {
            //     // 如果點擊的是圖片元素
            //     if (e.target instanceof HTMLImageElement) {
            //         // 獲取圖片路徑
            //         const path = e.target.getAttribute("src");
            //         // 創建新的圖片元素並設定圖片路徑
            //         const img = document.createElement('img');
            //         img.src = path;
            //         // 獲取選擇範圍
            //         const selection = window.getSelection();
            //         // 如果有選擇範圍
            //         if (selection.rangeCount > 0) {
            //             // 獲取範圍
            //             const range = selection.getRangeAt(0);
            //             // 刪除範圍內容並插入圖片
            //             range.deleteContents();
            //             range.insertNode(img);
            //         }
            //         // 隱藏圖片選擇器對話框
            //         imgSelector.hide();
            //     }
            // });

            // // 監聽按鈕點擊事件，當按鈕被點擊時執行以下程式碼
            // btnSelector.addEventListener("click", async () => {
            //     try {
            //         // 發送 HTTP 請求以獲取圖片資料
            //         const response = await fetch("./get-image.php");
            //         // 如果響應不正常，拋出錯誤
            //         if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            //         // 將收到的圖片資料解析為 JSON 格式
            //         const imgDatas = await response.json();
            //         // 清空圖片容器
            //         imgContainer.innerHTML = "";
            //         // 遍歷圖片資料，將每個圖片顯示在網頁上
            //         imgDatas.forEach(img => {
            //             const tmp = `<img src="./uploadmj/${img}">`;
            //             imgContainer.innerHTML += tmp;
            //         })
            //         // 顯示圖片選擇器
            //         imgSelector.show();
            //     } catch (err) {
            //         // 如果有錯誤發生，輸出錯誤訊息到控制台
            //         console.error("Fetch error: ", err);
            //     }
            //     // 顯示圖片選擇器
            //     imgSelector.show();
            // });

            // // 監聽按鈕點擊事件，當按鈕被點擊時觸發 fileInput 元素的點擊事件
            // btnUpload.addEventListener("click", () => {
            //     fileInput.click();
            // });

            // // 監聽 fileInput 元素的變化事件，當檔案選擇完畢時執行以下程式碼
            // fileInput.addEventListener("change", async () => {
            //     // 獲取選擇的檔案
            //     const file = fileInput.files[0];
            //     // 如果有選擇檔案
            //     if (file) {
            //         // 創建 FormData 物件並將檔案附加到其中
            //         const formData = new FormData();
            //         formData.append("file", file);
            //         try {
            //             // 發送 HTTP POST 請求以上傳檔案
            //             const response = await fetch("./doUploadImage.php", {
            //                 method: "POST",
            //                 body: formData
            //             });
            //             // 如果響應不正常，拋出錯誤
            //             if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            //             // 解析響應內容為 JSON 格式
            //             const result = await response.json();
            //             // 如果上傳成功
            //             if (result.success) {
            //                 // 創建圖片元素並設定圖片路徑
            //                 const img = document.createElement('img');
            //                 img.src = `./uploadmj/${result.filename}`;
            //                 // 獲取選擇範圍
            //                 const selection = window.getSelection();
            //                 // 如果有選擇範圍
            //                 if (selection.rangeCount > 0) {
            //                     // 獲取範圍
            //                     const range = selection.getRangeAt(0);
            //                     // 刪除範圍內容並插入圖片
            //                     range.deleteContents();
            //                     range.insertNode(img);
            //                 }
            //             } else {
            //                 // 如果上傳失敗，輸出錯誤訊息到控制台
            //                 console.error("Upload error: ", result.message);
            //             }
            //         } catch (err) {
            //             // 如果有錯誤發生，輸出錯誤訊息到控制台
            //             console.error("Upload error: ", err);
            //         }
            //     }
            // });
        </script>
</body>

</html>