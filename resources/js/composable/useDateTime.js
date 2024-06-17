import moment from 'moment';

export function useDatetime() {
  const formatDatetime = (value) => {
    return moment(value)
      .format("DD/MMM/YYYY h:mm A")
      .toUpperCase()
      .replace(".", "");
  };

  return { formatDatetime };
}