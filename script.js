document.addEventListener('DOMContentLoaded', () => {
    // --- 1. ハンバーガーメニューの制御 ---
    const hamburger = document.getElementById('js-hamburger');
    const nav = document.getElementById('js-nav');
    const body = document.body;
    const navLinks = document.querySelectorAll('#js-nav a');

    if (hamburger && nav) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('is-active');
            nav.classList.toggle('is-active');
            body.classList.toggle('is-fixed');
        });

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (href.startsWith('#')) {
                    e.preventDefault();
                    const targetId = href.replace('#', '');
                    const targetElement = document.getElementById(targetId);

                    hamburger.classList.remove('is-active');
                    nav.classList.remove('is-active');
                    body.classList.remove('is-fixed');

                    if (targetElement) {
                        const headerHeight = 70;
                        const elementPosition = targetElement.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerHeight;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    }
});

// --- 2. 予約フォーム送信機能 ---
function sendReservationEmail() {
    const fields = [
        { id: 'res-name', name: 'お名前' },
        { id: 'res-tel', name: 'お電話番号' },
        { id: 'res-email', name: 'メールアドレス' },
        { id: 'res-date1', name: '希望日時1' },
        { id: 'res-date2', name: '希望日時2' },
        { id: 'res-date3', name: '希望日時3' }
    ];

    let isError = false;

    // 赤枠のリセット
    fields.forEach(field => {
        const el = document.getElementById(field.id);
        if (el) el.classList.remove('input-error');
    });

    // チェック処理
    fields.forEach(field => {
        const element = document.getElementById(field.id);
        if (element && !element.value) {
            element.classList.add('input-error');
            isError = true;
        }
    });

    if (isError) {
        return;
    }

    // 値を取得して送信
    const name = document.getElementById('res-name').value;
    const tel = document.getElementById('res-tel').value;
    const email = document.getElementById('res-email').value;
    const menuElement = document.querySelector('input[name="menu"]:checked');
    const menu = menuElement ? menuElement.value : "";
    const date1 = document.getElementById('res-date1').value;
    const date2 = document.getElementById('res-date2').value;
    const date3 = document.getElementById('res-date3').value;
    const message = document.getElementById('res-message').value;

    const subject = "【予約希望】";
    const body = `お名前：${name}
電話番号：${tel}
メールアドレス：${email}
ご希望メニュー：${menu}
希望日時1：${date1}
希望日時2：${date2}
希望日時3：${date3}
お悩み・目標：
${message}`;

    window.location.href = `mailto:hayate032606@icloud.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
}

