import { callApi } from "./api";
import { setOptions, type Options } from "./store";


export function updateOption<T extends keyof Options>(
    key: T,
    value: Options[T],
    onSuccess?: () => void,
    onError?: (err: Error) => void,
) {

    callApi(
        "PATCH",
        "/option",
        {
            [key]: value,
        },
        (response) => {
            setOptions(response);
            if (onSuccess) {
                onSuccess();
            }
        },
        (err) => {
            if (onError) {
                onError(err);
            }
        },
    );

}
