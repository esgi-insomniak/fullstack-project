export const getInitials = (name) => {
    const names = name.split(' ')
    const initials = names.map((n) => n[0]).join('')
    return initials
}