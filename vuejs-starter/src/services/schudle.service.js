import { getAxiosInstance } from "../helpers/axios/config.js";
import moment from "moment/dist/moment";
import fr from "moment/dist/locale/fr";
moment.locale("fr", fr);

class GarageSchudleEventService {
  async getCollection(params = null) {
    return getAxiosInstance()
      .get("garage_schudle_events", { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async get(id) {
    return getAxiosInstance()
      .get(`garage_schudle_events/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async getGarageEvents(id, params = null) {
    return getAxiosInstance()
      .get(`garages/${id}/garage_schudle_events`, { params: params })
      .then((response) => {
        return response.data;
      });
  }

  async post(garageSchudleEvent) {
    return getAxiosInstance()
      .post("garage_schudle_events", garageSchudleEvent)
      .then((response) => {
        return response.data;
      });
  }

  async put(id, garageSchudleEvent) {
    return getAxiosInstance()
      .put(`garage_schudle_events/${id}`, garageSchudleEvent)
      .then((response) => {
        return response.data;
      });
  }

  async patch(id, garageSchudleEvent) {
    return getAxiosInstance()
      .patch(`garage_schudle_events/${id}`, garageSchudleEvent)
      .then((response) => {
        return response.data;
      });
  }

  async delete(id) {
    return getAxiosInstance()
      .delete(`garage_schudle_events/${id}`)
      .then((response) => {
        return response.data;
      });
  }

  async getCalendarDisponibilities(
    concessionId,
    fromDate,
    toDate,
    allowWeekend = false
  ) {
    const disponibilitySchedule = [
      {
        start: "08:00",
        end: "10:00",
      },
      {
        start: "10:00",
        end: "12:00",
      },
      {
        start: "14:00",
        end: "16:00",
      },
      {
        start: "16:00",
        end: "18:00",
      },
    ];

    const events = await this.getGarageEvents(concessionId, {
      "dateStart[after]": fromDate.toISOString(),
      "dateEnd[before]": toDate.toISOString(),
    });
    const eventsDateStart = events.map((event) =>
      moment(event.dateStart).toISOString()
    );
    const disponibilities = [];
    for (let i = 1; i < 8; i++) {
      const day = moment().add(i, "days").startOf("day");
      for (let j = 0; j < disponibilitySchedule.length; j++) {
        if (!allowWeekend && (day.day() === 0 || day.day() === 6)) {
          continue;
        }
        const start = moment(day).set(
          "hour",
          disponibilitySchedule[j].start.split(":")[0]
        );
        const end = moment(day).set(
          "hour",
          disponibilitySchedule[j].end.split(":")[0]
        );
        const disponibility = {
          label: `${day.format("dddd MM/DD")} : ${start.format(
            "HH:mm"
          )} - ${end.format("HH:mm")}`,
          horaire: `${start.format("HH:mm")} - ${end.format("HH:mm")}`,
          start: start.toISOString(),
          end: end.toISOString(),
          isDisponible: eventsDateStart.includes(start.toISOString())
            ? false
            : true,
        };
        const dayInfo = day.format("dddd MM/DD");
        if (!disponibilities.find((dispo) => dispo.dayInfo === dayInfo)) {
          disponibilities.push({
            dayInfo: dayInfo,
            disponibilities: [disponibility],
          });
        } else {
          disponibilities
            .find((dispo) => dispo.dayInfo === dayInfo)
            .disponibilities.push(disponibility);
        }
      }
    }
    return disponibilities;
  }
}

export default new GarageSchudleEventService();
