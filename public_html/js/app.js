async function getJson(url) {
    let response = await fetch(url);
    let data = await response.json();
    return data;
}

async function submitForm(form) {
    try {
        let formData = new FormData(form);
        let response = await fetch(form.action, {
            method: form.method,
            body: formData
        });

        const text = await response.text();
        console.log("Response Text:", text);

        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            throw new Error("Не удалось распарсить ответ как JSON: " + e.message + ". Ответ: " + text);
        }

        if (response.ok) {
            alert(data.message);

            if (data.redirect) {
                console.log("Redirecting to:", data.redirect);
                window.location.href = data.redirect;
            }
            if (data.refresh === true) {
                location.reload();
            }
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error("Произошла ошибка:", error);
    }
}






let form = document.querySelector("form.ajax");
if (form) {
    form.onsubmit = function(event) {
        event.preventDefault();
        submitForm(this);
    };
}

async function handleLink(event) {
    event.preventDefault();
    let url = event.currentTarget.href;
    try {
        let response = await fetch(url);
        let data = await response.json();

        if (!response.ok) {
            alert(data.message);
            throw new Error("Ошибка: ${data.message}");
        } else {
            alert(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            }
            if (data.refresh === true) {
                location.reload();
            }
        }
    } catch (error) {
        console.error("Произошла ошибка:", error);
    }
}

let links = document.querySelectorAll("a.ajax");
if (links) {
    links.forEach(link => {
        link.addEventListener("click", handleLink);
    });
}