//creates a async function 
async function fetchLocations() {
    try {
        //starts a promise that calls the api
        const response = await fetch('http://localhost:8080/projecteDAW/apis/locationApi.php');
        const data = await response.json();
        return data
    } catch (error) {
        console.error('Error fetching locations:', error);
    }
}
fetchLocations();