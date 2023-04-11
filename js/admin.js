document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-button");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            const confirmDelete = confirm("Вы уверены, что хотите удалить эту запись?");

            if (confirmDelete) {
                const itemId = this.dataset.id;
                const itemType = this.dataset.type;

                fetch(`admin/delete_${itemType}.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ id: itemId }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert("Ошибка удаления. Пожалуйста, попробуйте еще раз.");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("Ошибка удаления. Пожалуйста, попробуйте еще раз.");
                    });
            }
        });
    });
});
