
import axios from "axios";

export const OpenDrawer = (roles) => {
    axios
      .get("/api/open-drawer")
      .then((response) => {
        console.log(response.data);
        alert("Cash drawer opened successfully!");
      })
      .catch((error) => {
        console.error(
          "Error opening cash drawer:",
          error.response?.data || error.message
        );
        // alert("Failed to open cash drawer.");
      });
};