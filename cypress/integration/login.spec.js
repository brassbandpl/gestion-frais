describe('Login', () => {
  
  beforeEach(() => {
    cy.visit('http://bbpl-gestionfrais.local:8000/')
  })

  it('Mauvais identifiant', () => {
    cy.get('#inputUsername')
      .type('fake_user')
    cy.get('#inputPassword')
      .type('pwd')
    cy.contains('Se connecter').click()
    cy.get('.alert-danger')
      .should('contain', 'Username could not be found.')
  })

  it('Mauvais mot de passe', () => {
    cy.get('#inputUsername')
      .type('toto_admin')
    cy.get('#inputPassword')
      .type('azertyuiop')
    cy.contains('Se connecter').click()
    cy.get('.alert-danger')
      .should('contain', 'Invalid credentials.')
  })

  it('Identification OK', () => {
    cy.get('#inputUsername')
      .type('toto_admin')
    cy.get('#inputPassword')
      .type('pwd')
    cy.contains('Se connecter').click()
    cy.url().should('eq', 'http://bbpl-gestionfrais.local:8000/event/list')
  })
})