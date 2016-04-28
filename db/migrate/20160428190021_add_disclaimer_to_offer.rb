class AddDisclaimerToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :disclaimer, :text
  end
end
