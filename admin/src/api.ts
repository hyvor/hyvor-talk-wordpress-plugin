

export function callApi(
    method: 'GET' | 'POST' | 'PUT' | 'DELETE',
    endpoint: string,
    data?: any
) {

    endpoint = endpoint.replace(/^\//, '');
    endpoint = '/' + endpoint;

    (window as any).jQuery.ajax({
        method,
        url: (window as any).HYVOR_TALK_REST_URL + endpoint,
        data,
        success: (response: any) => {
            console.log(response);
        },
        error: (error: any) => {
            console.error(error);
        }
    });

}
