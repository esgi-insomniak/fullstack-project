export const getInitials = (name) => {
    const names = name.split(' ')
    return names.map((n) => n[0]).join('')
}

export const generateICalendar = (data) => {
    const startDate = data.start
    const endDate = data.end
    const eventSummary = data.title
    const eventLocation = data.location
    const eventDescription = data.description
    const icsFileContent = `BEGIN:VCALENDAR
    VERSION:2.0
    PRODID:-//Company Name//Product//Language
    BEGIN:VEVENT
    DTSTART:${startDate}
    DTEND:${endDate}
    SUMMARY:${eventSummary}
    LOCATION:${eventLocation}
    DESCRIPTION:${eventDescription}
    END:VEVENT
    END:VCALENDAR`
    return icsFileContent
}