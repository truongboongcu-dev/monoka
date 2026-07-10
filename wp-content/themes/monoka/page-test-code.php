<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tử Vi AI - Sức Mạnh n8n & Gemini</title>
    <style>
        :root {
            --primary: #e67e22;
            --secondary: #d35400;
            --bg: #f8f9fa;
            --text: #2c3e50;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: var(--bg); 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            padding: 20px; 
            color: var(--text); 
        }
        .card { 
            background: white; 
            padding: 30px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
            width: 100%; 
            max-width: 500px; 
            margin-bottom: 20px; 
            box-sizing: border-box;
        }
        h2 { 
            color: var(--secondary); 
            text-align: center; 
            margin-top: 0; 
            font-size: 24px; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
        }
        .input-group { 
            margin-bottom: 15px; 
        }
        label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: 600; 
            font-size: 14px; 
            color: #7f8c8d; 
        }
        input, select, button { 
            width: 100%; 
            padding: 14px; 
            border-radius: 10px; 
            border: 1px solid #ddd; 
            box-sizing: border-box; 
            font-size: 16px; 
            outline: none; 
            transition: 0.3s; 
        }
        input:focus, select:focus { 
            border-color: var(--primary); 
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1); 
        }
        button { 
            background: var(--primary); 
            color: white; 
            font-weight: bold; 
            border: none; 
            cursor: pointer; 
            margin-top: 10px; 
        }
        button:hover { 
            background: var(--secondary); 
            transform: translateY(-1px); 
        }
        button:disabled { 
            background: #bdc3c7; 
            cursor: not-allowed; 
            transform: none; 
        }
        
        #loading { 
            display: none; 
            text-align: center; 
            margin: 20px 0; 
            color: var(--primary); 
        }
        .spinner { 
            width: 30px; 
            height: 30px; 
            border: 3px solid rgba(230,126,34,.2); 
            border-top: 3px solid var(--primary); 
            border-radius: 50%; 
            animation: spin 1s linear infinite; 
            margin: 0 auto 10px; 
        }
        @keyframes spin { 
            0% { transform: rotate(0deg); } 
            100% { transform: rotate(360deg); } 
        }

        .ket-qua { 
            background: white; 
            width: 100%; 
            max-width: 500px; 
            border-radius: 20px; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); 
            display: none; 
            overflow: hidden; 
            box-sizing: border-box;
        }
        .section { 
            padding: 20px; 
            border-bottom: 1px solid #f1f1f1; 
        }
        .section:last-child { 
            border-bottom: none; 
        }
        .section-title { 
            font-weight: bold; 
            color: var(--secondary); 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            margin-bottom: 10px; 
            font-size: 18px; 
        }
        .content { 
            line-height: 1.7; 
            color: #444; 
            font-size: 15px; 
            white-space: pre-line; 
            text-align: justify; 
        }
        
        .error-box { 
            background: #fff5f5; 
            color: #c53030; 
            padding: 15px; 
            border-radius: 10px; 
            margin-top: 15px; 
            font-size: 13px; 
            display: none; 
            border: 1px solid #feb2b2; 
            line-height: 1.5; 
        }
        
        .debug-panel { 
            margin-top: 20px; 
            width: 100%; 
            max-width: 500px; 
            font-size: 12px; 
            color: #777; 
            border: 1px dashed #ccc; 
            border-radius: 10px; 
            padding: 12px; 
            display: none; 
            box-sizing: border-box;
        }
        .debug-title { 
            cursor: pointer; 
            text-decoration: underline; 
            margin-bottom: 8px; 
            display: block; 
            font-weight: bold; 
            text-align: center;
        }
        .debug-content { 
            display: none; 
            white-space: pre-wrap; 
            word-break: break-all; 
            background: #f1f1f1; 
            padding: 10px; 
            border-radius: 8px; 
            color: #333;
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Tử Vi AI Số Mệnh</h2>
    
    <div class="input-group">
        <label>Họ và tên</label>
        <input type="text" id="name" placeholder="Ví dụ: Nguyễn Văn A">
    </div>
    <div class="input-group">
        <label>Ngày tháng năm sinh</label>
        <input type="date" id="dob">
    </div>
    <div class="input-group">
        <label>Giới tính</label>
        <select id="gender">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>
    </div>
    <button id="btn">XEM LUẬN GIẢI</button>
    
    <div id="loading">
        <div class="spinner"></div>
        <span>Đang kết nối vũ trụ và dịch lý...</span>
    </div>

    <div id="error-display" class="error-box"></div>
</div>

<div class="ket-qua" id="ket-qua">
    <div class="section">
        <div class="section-title">🌟 TỔNG QUAN BẢN MỆNH</div>
        <div id="tong-quan" class="content"></div>
    </div>
    <div class="section">
        <div class="section-title">❤️ TÌNH DUYÊN GIA ĐẠO</div>
        <div id="tinh-duyen" class="content"></div>
    </div>
    <div class="section">
        <div class="section-title">💼 SỰ NGHIỆP TÀI LỘC</div>
        <div id="su-nghiep" class="content"></div>
    </div>
</div>

<div class="debug-panel" id="debug-panel">
    <div id="debug-content" class="debug-content"></div>
</div>

<script>
    // Link Webhook chính thức (Production)
    const N8N_WEBHOOK_URL = 'https://ha44.app.n8n.cloud/webhook/tu-vi-ai';

    const btn = document.getElementById('btn');
    const loading = document.getElementById('loading');
    const resultBox = document.getElementById('ket-qua');
    const errorBox = document.getElementById('error-display');
    const debugPanel = document.getElementById('debug-panel');
    const debugContent = document.getElementById('debug-content');

    function toggleDebug() {
        debugContent.style.display = debugContent.style.display === 'block' ? 'none' : 'block';
    }

    // Hàm quét từ khóa linh hoạt không phân biệt hoa/thường hay dấu gạch dưới
    function smartMap(obj, keywords) {
        if (!obj || typeof obj !== 'object') return null;
        const keys = Object.keys(obj);
        for (let kw of keywords) {
            const foundKey = keys.find(k => k.toLowerCase().replace(/_/g, '').includes(kw.toLowerCase()));
            if (foundKey) return obj[foundKey];
        }
        return null;
    }

    btn.addEventListener('click', async () => {
        const name = document.getElementById('name').value.trim();
        const dob = document.getElementById('dob').value;
        const gender = document.getElementById('gender').value;

        if (!name || !dob) {
            alert("Vui lòng nhập đầy đủ Họ tên và Ngày sinh!");
            return;
        }

        btn.disabled = true;
        loading.style.display = 'block';
        resultBox.style.display = 'none';
        errorBox.style.display = 'none';
        debugPanel.style.display = 'none';
        debugContent.style.display = 'none';

        try {
            // Giới hạn thời gian chờ 60 giây
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 60000); 

            const response = await fetch(N8N_WEBHOOK_URL, {
                method: "POST",
                headers: { 
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ name, dob, gender }),
                signal: controller.signal
            });

            clearTimeout(timeoutId);

            if (!response.ok) throw new Error("Lỗi phản hồi từ n8n (HTTP " + response.status + ")");

            const responseData = await response.json();
            
            // Đổ dữ liệu vào bảng Debug để theo dõi
            debugContent.innerText = JSON.stringify(responseData, null, 2);
            debugPanel.style.display = 'block';

            // Xử lý dữ liệu đầu vào (n8n có thể trả mảng hoặc object)
            let rawResult = Array.isArray(responseData) ? responseData[0] : responseData;
            
            // QUÉT SÂU TÌM CHUỖI KẾT QUẢ CỦA GEMINI
            let contentStr = "";
            if (typeof rawResult === 'string') {
                contentStr = rawResult;
            } else if (rawResult && typeof rawResult === 'object') {
                contentStr = rawResult.text || 
                             rawResult.output || 
                             // Quét cấu trúc mảng parts (Đặc trưng của Gemini API mới)
                             (rawResult.parts && rawResult.parts[0] ? rawResult.parts[0].text : null) ||
                             // Quét cấu trúc content lồng parts
                             (rawResult.content && typeof rawResult.content === 'string' ? rawResult.content : null) ||
                             (rawResult.content && rawResult.content.parts ? rawResult.content.parts[0].text : null) ||
                             rawResult.message;
                             
                if (!contentStr) {
                    // Phương án dự phòng cuối cùng: Ép kiểu nguyên object sang chuỗi
                    contentStr = JSON.stringify(rawResult);
                }
            }
            
            let finalData = { tong_quan: "", tinh_duyen: "", su_nghiep: "" };

            if (contentStr) {
                try {
                    // Dọn dẹp chuỗi kỹ lưỡng: lọc thẻ code markdown, fix lỗi ký tự ẩn
                    let cleanStr = contentStr.trim()
                        .replace(/^json/i, '')
                        .replace(/```json/gi, '')
                        .replace(/```/g, '')
                        .replace(/\\n/g, '\n')
                        .replace(/[\u0000-\u0008\u000B-\u000C\u000E-\u001F\u007F-\u009F]/g, "") 
                        .trim();

                    const start = cleanStr.indexOf('{');
                    const end = cleanStr.lastIndexOf('}');
                    
                    if (start !== -1 && end !== -1) {
                        const parsed = JSON.parse(cleanStr.substring(start, end + 1));
                        finalData.tong_quan = smartMap(parsed, ["tongquan", "tong_quan", "overview", "tổng", "bản mệnh"]) || "";
                        finalData.tinh_duyen = smartMap(parsed, ["tinhduyen", "tinh_duyen", "love", "tình", "gia đạo"]) || "";
                        finalData.su_nghiep = smartMap(parsed, ["sunghiep", "su_nghiep", "career", "sự", "tài lộc"]) || "";
                    }
                } catch (e) {
                    console.warn("Không thể bóc tách JSON chuẩn, tự động áp dụng hiển thị thô.");
                }

                // Nếu không bóc tách được riêng rẽ thì gộp toàn bộ text trả về vào ô Tổng quan
                if (!finalData.tong_quan && !finalData.tinh_duyen && !finalData.su_nghiep) {
                    finalData.tong_quan = contentStr;
                }
            }

            // Gán kết quả xuất ra giao diện
            document.getElementById('tong-quan').innerText = finalData.tong_quan || "Dữ liệu trống hoặc AI chưa trả về nội dung.";
            document.getElementById('tinh-duyen').innerText = finalData.tinh_duyen || "Chưa trích xuất được thông tin mục này.";
            document.getElementById('su-nghiep').innerText = finalData.su_nghiep || "Chưa trích xuất được thông tin mục này.";

            resultBox.style.display = 'block';
            resultBox.scrollIntoView({ behavior: 'smooth' });

        } catch (error) {
            errorBox.innerHTML = `<b>⚠️ Lỗi hệ thống:</b> ${error.name === 'AbortError' ? 'Thời gian xử lý quá lâu (Vượt quá 60 giây)' : error.message}`;
            errorBox.style.display = 'block';
        } finally {
            loading.style.display = 'none';
            btn.disabled = false;
        }
    });
</script>

</body>
</html>