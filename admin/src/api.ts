

export function callApi(
    method: 'GET' | 'POST' | 'PUT' | 'PATCH' | 'DELETE',
    endpoint: string,
    data?: Record<string, any>,
    onSuccess?: (response: any) => void,
    onError?: (error: any) => void
) {

    endpoint = endpoint.replace(/^\//, '');
    endpoint = '/' + endpoint;

    const isJson = method !== 'GET';

    (window as any).jQuery.ajax({
        method,
        url: (window as any).HYVOR_TALK_REST_URL + endpoint,
        data: isJson ? JSON.stringify(data) : data,
        contentType: isJson ? 'application/json' : undefined,

        beforeSend: (xhr: any) => {
            xhr.setRequestHeader('X-WP-Nonce', (window as any).HYVOR_TALK_NONCE);
        },
        success: (response: any) => {
            if (onSuccess) {
                onSuccess(response);
            }
        },
        error: (error: any) => {
            if (onError) {
                onError(error);
            } else {
                console.error(error);
            }
        }
    });

}
