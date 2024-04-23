export const fetchData = async (url: string) => {
    const response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
    });
    const data = await response.json();
    if (!response.ok) {
        throw Error(`${data.status} error: ${data.title}` || "Failed to fetch data");
    }
    return data;
}