class AddDateToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :available_date, :string
  end
end
