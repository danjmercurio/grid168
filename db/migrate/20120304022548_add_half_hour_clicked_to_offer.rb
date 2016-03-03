class AddHalfHourClickedToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :half_hour_clicked, :text
  end
end
