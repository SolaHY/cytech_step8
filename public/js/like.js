document.addEventListener('DOMContentLoaded', function () {
    const likeBtn = document.getElementById('like-btn');

    if (likeBtn) {
        likeBtn.addEventListener('click', function () {
            const blogId = this.getAttribute('data-blog-id');
            const url = `/blogs/${blogId}/like`;
            const method = this.querySelector('i').style.color === 'red' ? 'DELETE' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('like-count').textContent = data.likes_count;
                    // ハートアイコンの色を変更
                    const heartIcon = this.querySelector('i');
                    heartIcon.style.color = method === 'POST' ? 'red' : 'black';
                });
        });
    }
});