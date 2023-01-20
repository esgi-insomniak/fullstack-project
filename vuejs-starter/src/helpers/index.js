export const getInitials = (name) => {
    const names = name.split(' ')
    return names.map((n) => n[0]).join('')
}