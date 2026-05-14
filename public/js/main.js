async function main() {
    let response = await fetch('/test', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({data: '321'}),
    });
    console.log(response);
    let data = await response.json();
    console.log(data);
}

main();