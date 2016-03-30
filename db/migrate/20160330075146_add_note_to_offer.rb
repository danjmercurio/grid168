class AddNoteToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :notes, :text
  end
end
