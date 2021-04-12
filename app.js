document.addEventListener('DOMContentLoaded', init, false);

function init() {
    if ('serviceWorker' in navigator && navigator.onLine) {
        navigator.serviceWorker.register('worker.js')
        .then(async (reg) => {
            if('PushManager' in window) {
                function urlBase64ToUint8Array(base64String) {
                    const padding = '='.repeat((4 - base64String.length % 4) % 4);
                    const base64 = (base64String + padding)
                        .replace(/-/g, '+')
                        .replace(/_/g, '/');
                    
                    const rawData = window.atob(base64);
                    const outputArray = new Uint8Array(rawData.length);
                    
                    for (let i = 0; i < rawData.length; ++i) {
                        outputArray[i] = rawData.charCodeAt(i);
                    }
                    return outputArray;
                }

                const subs = await reg.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array("BCNDqS4xwBk7Cu0WjfLuhHg2PvZw71KtLjRgKxJ_z_lu9ABijprRZVc-PoVJa75h3QLs-aTAVBfRbSRS9ckuUp0")
                });

                await fetch(base_url + '/notif/getsubs', {
                    method: 'POST',
                    body: JSON.stringify(subs),
                    headers: {'Content-Type': 'application/json'}
                })
            }
        }, (err) => {
            console.error('Failed to run sw', err);
        });
    }
}
