describe('template spec', () => {
  it('passes', () => {
    cy.visit(`${Cypress.env('HOST_URL')}login`)
    cy.login(Cypress.env('USER_ID'), Cypress.env('USER_PSWD'))
    cy.url().should('include', '/home')
    cy.contains('div', 'Services').click()
    cy.url().should('include', '/services')
    cy.get('ul[class="formkit-options"]').children().then($childrens => {
      const random = Math.floor(Math.random() * $childrens.length)
      cy.get('ul[class="formkit-options"]').children().eq(random).click()
    })
    cy.get('button').contains('Question suivante').click()
    cy.get('select[name="model"]').children().should('have.length.gt', 2)
    cy.get('select[name="model"]').children().then($childrens => {
      const random = Math.floor(Math.random() * $childrens.length)
      cy.get('select[name="model"]').select($childrens.eq(random).val())
    })
    cy.get('button').contains('Question suivante').click()
    cy.get('input[name="kilometrage"]').type(Math.floor(Math.random() * (100000 - 5000) + 5000))
    cy.get('button').contains('Question suivante').click()
    cy.get('ul[class="formkit-options"]').children().then($childrens => {
      const random = Math.floor(Math.random() * $childrens.length)
      cy.get('ul[class="formkit-options"]').children().eq(random).click()
    })
    cy.get('button').contains('Question suivante').click()
    cy.get('ul[class="formkit-options"]').children().then($childrens => {
      const random = Math.floor(Math.random() * $childrens.length)
      cy.get('ul[class="formkit-options"]').children().eq(random).click()
    })
    cy.get('button').contains('Question suivante').click()
    cy.get('select[name="concession"]').children().should('have.length.gt', 2)
    cy.get('select[name="concession"]').children().then($childrens => {
      const random = Math.floor(Math.random() * $childrens.length)
      cy.get('select[name="concession"]').select($childrens.eq(random).val())
    })
    cy.get('button').contains('Question suivante').click()
    cy.get('select[name="appointement"]').children().should('have.length.gt', 2)
    cy.get('select[name="appointement"]').children().then($childrens => {
      const random = Math.floor(Math.random() * ($childrens.length - 1)) + 1
      cy.get('select[name="appointement"]').select($childrens.eq(random).val())
    })
    cy.get('button').contains('Demande de RDV').click()
    cy.get('div').children().contains('Votre demande à bien été prise en compte, retrouver votre rendez-vous sur votre profil.').should('be.visible')
  })
})